<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DriverSource;
use App\Enums\ServiceType;
use App\Enums\TrustTier;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TransporterProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DriverController extends Controller
{
    public function create(): View
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'phone'         => ['required', 'string', 'max:20'],
            'whatsapp'      => ['nullable', 'string', 'max:20'],
            'bio'           => ['nullable', 'string', 'max:500'],
            'trust_tier'    => ['required', 'in:' . implode(',', array_column(TrustTier::cases(), 'value'))],
            'driver_source' => ['required', 'in:' . implode(',', array_column(DriverSource::cases(), 'value'))],
            'service_types' => ['required', 'array', 'min:1'],
            'service_types.*' => ['in:' . implode(',', array_column(ServiceType::cases(), 'value'))],
        ]);

        DB::transaction(function () use ($data, $request) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'phone'    => $data['phone'],
                'password' => Hash::make(str()->random(16)),
                'role'     => UserRole::TransportPartner,
            ]);

            TransporterProfile::create([
                'user_id'       => $user->id,
                'phone'         => $data['phone'],
                'whatsapp'      => $data['whatsapp'] ?? $data['phone'],
                'bio'           => $data['bio'] ?? null,
                'trust_tier'    => $data['trust_tier'],
                'driver_source' => $data['driver_source'],
                'service_types' => $data['service_types'],
                'reviewed_by'   => $data['trust_tier'] !== TrustTier::Unverified->value ? auth()->id() : null,
                'reviewed_at'   => $data['trust_tier'] !== TrustTier::Unverified->value ? now() : null,
                'is_active'     => true,
            ]);
        });

        return redirect()
            ->route('admin.drivers.index')
            ->with('success', "Driver {$data['name']} added successfully.");
    }

    public function index(Request $request): View
    {
        $query = TransporterProfile::with('user')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
                ->orWhere('phone', 'like', "%{$search}%");
        }

        if ($request->filled('tier')) {
            $query->where('trust_tier', $request->tier);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $drivers = $query->paginate(20)->withQueryString();

        $counts = [
            'total'    => TransporterProfile::count(),
            'verified' => TransporterProfile::where('trust_tier', TrustTier::Verified->value)->count(),
            'reviewed' => TransporterProfile::where('trust_tier', TrustTier::ManuallyReviewed->value)->count(),
            'pending'  => TransporterProfile::where('trust_tier', TrustTier::Unverified->value)->count(),
            'active'   => TransporterProfile::where('is_active', true)->count(),
        ];

        return view('admin.drivers.index', compact('drivers', 'counts'));
    }

    public function show(TransporterProfile $driver): View
    {
        $driver->load('user', 'reviewer');

        $recentTasks = Task::where('assigned_driver_id', $driver->id)
            ->with('user')
            ->latest()
            ->limit(10)
            ->get();

        $taskCounts = [
            'total'     => Task::where('assigned_driver_id', $driver->id)->count(),
            'delivered' => Task::where('assigned_driver_id', $driver->id)->where('status', 'delivered')->count(),
        ];

        return view('admin.drivers.show', compact('driver', 'recentTasks', 'taskCounts'));
    }

    public function updateTrust(Request $request, TransporterProfile $driver): RedirectResponse
    {
        $request->validate([
            'trust_tier'  => ['required', 'in:' . implode(',', array_column(TrustTier::cases(), 'value'))],
            'trust_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $driver->update([
            'trust_tier'  => $request->trust_tier,
            'trust_notes' => $request->trust_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', "Trust tier updated to {$request->trust_tier}.");
    }

    public function toggleActive(TransporterProfile $driver): RedirectResponse
    {
        $driver->update(['is_active' => !$driver->is_active]);

        return back()->with('success', $driver->is_active ? 'Driver activated.' : 'Driver deactivated.');
    }
}
