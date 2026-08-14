<?php

namespace App\Http\Controllers;

use App\Enums\TrustTier;
use App\Enums\UserRole;
use App\Models\Task;
use App\Models\TransporterProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $data = match($user->role) {
            UserRole::Admin           => $this->adminData(),
            UserRole::TransportPartner => $this->driverData($user),
            default                   => $this->senderData($user),
        };

        return view('dashboard', $data);
    }

    private function adminData(): array
    {
        $totalOrders    = Task::count();
        $totalDrivers   = TransporterProfile::count();
        $activeDrivers  = TransporterProfile::where('is_active', true)->count();
        $pendingReview  = TransporterProfile::where('trust_tier', TrustTier::Unverified->value)->count();
        $verifiedDrivers= TransporterProfile::where('trust_tier', TrustTier::Verified->value)->count();

        $recentOrders = Task::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return compact(
            'totalOrders', 'totalDrivers', 'activeDrivers',
            'pendingReview', 'verifiedDrivers', 'recentOrders'
        );
    }

    private function driverData(User $user): array
    {
        $profile        = $user->transporterProfile;
        $assignedTasks  = Task::where('assigned_driver_id', $profile?->id)->count();
        $completedTasks = Task::where('assigned_driver_id', $profile?->id)
            ->where('status', 'delivered')
            ->count();


        $recentOrders = Task::where('assigned_driver_id', $profile?->id)
            ->latest()
            ->limit(8)
            ->get();

        return compact('profile', 'assignedTasks', 'completedTasks', 'recentOrders');
    }

    private function senderData(User $user): array
    {
        $totalOrders     = Task::where('user_id', $user->id)->count();
        $pendingOrders   = Task::where('user_id', $user->id)
            ->whereIn('status', ['posted', 'assigned', 'in_progress'])
            ->count();
        $deliveredOrders = Task::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->count();
        $cancelledOrders = Task::where('user_id', $user->id)
            ->where('status', 'cancelled')
            ->count();

        $activeOrders = Task::where('user_id', $user->id)
            ->whereIn('status', ['posted', 'assigned', 'in_progress'])
            ->with('assignedDriver.user')
            ->latest()
            ->get();

        $pastOrders = Task::where('user_id', $user->id)
            ->whereIn('status', ['delivered', 'cancelled'])
            ->with('assignedDriver.user')
            ->latest()
            ->limit(10)
            ->get();

        return compact(
            'totalOrders', 'pendingOrders', 'deliveredOrders',
            'cancelledOrders', 'activeOrders', 'pastOrders'
        );
    }
}
