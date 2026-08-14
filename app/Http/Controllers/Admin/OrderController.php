<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TransporterProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Task::with(['user', 'assignedDriver.user'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('pickup_address', 'like', "%{$search}%")
                  ->orWhere('dropoff_address', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(25)->withQueryString();

        $counts = collect(TaskStatus::cases())->mapWithKeys(
            fn ($s) => [$s->value => Task::where('status', $s->value)->count()]
        )->toArray();
        $counts['total'] = Task::count();

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    public function show(Task $order): View
    {
        $order->load('user', 'assignedDriver.user');

        $availableDrivers = TransporterProfile::with('user')
            ->where('is_active', true)
            ->get();

        return view('admin.orders.show', compact('order', 'availableDrivers'));
    }

    public function updateStatus(Request $request, Task $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', array_column(TaskStatus::cases(), 'value'))],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated.');
    }

    public function assignDriver(Request $request, Task $order): RedirectResponse
    {
        $request->validate([
            'assigned_driver_id' => ['nullable', 'exists:transporter_profiles,id'],
        ]);

        $order->update(['assigned_driver_id' => $request->assigned_driver_id ?: null]);

        return back()->with('success', $request->assigned_driver_id
            ? 'Driver assigned successfully.'
            : 'Driver unassigned.');
    }
}
