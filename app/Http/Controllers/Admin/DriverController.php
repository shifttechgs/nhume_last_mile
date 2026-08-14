<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TrustTier;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TransporterProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DriverController extends Controller
{
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
