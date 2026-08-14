<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', UserRole::Sender)
            ->withCount('tasks')
            ->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        $customers = $query->paginate(25)->withQueryString();

        $total = $customers->total(); // paginator already has this count, no extra query needed

        return view('admin.customers.index', compact('customers', 'total'));
    }

    public function create(): View
    {
        return view('admin.customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'unique:users,email'],
        ]);

        $email = $data['email'] ?? $this->placeholderEmail($data['phone']);

        $customer = User::create([
            'name'     => $data['name'],
            'phone'    => $data['phone'],
            'email'    => $email,
            'password' => Hash::make(str()->random(16)),
            'role'     => UserRole::Sender,
        ]);

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with('success', "Customer {$customer->name} created.");
    }

    public function show(User $customer): View
    {
        abort_unless($customer->role === UserRole::Sender, 404);

        $orders = $customer->tasks()->latest()->paginate(15);

        return view('admin.customers.show', compact('customer', 'orders'));
    }

    public function search(Request $request): JsonResponse
    {
        $q = $request->string('q')->trim();

        $customers = User::where('role', UserRole::Sender)
            ->when($q->isNotEmpty(), function ($query) use ($q) {
                $query->where(function ($q2) use ($q) {
                    $q2->where('name', 'like', "%{$q}%")
                       ->orWhere('phone', 'like', "%{$q}%")
                       ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->withCount('tasks')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'phone', 'email'])
            ->map(fn ($c) => [
                'id'          => $c->id,
                'name'        => $c->name,
                'phone'       => $c->phone,
                'email'       => str_contains($c->email, '@nhume.local') ? null : $c->email,
                'tasks_count' => $c->tasks_count,
            ]);

        return response()->json($customers);
    }

    private function placeholderEmail(string $phone): string
    {
        $sanitized = preg_replace('/[^0-9a-z]/', '', strtolower($phone));
        return "{$sanitized}@nhume.local";
    }
}
