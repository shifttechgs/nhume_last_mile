<?php

namespace App\Http\Controllers;

use App\Enums\TrustTier;
use App\Enums\UserRole;
use App\Models\Task;
use App\Models\TransporterProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $data = match($user->role) {
            UserRole::Admin            => $this->adminData(),
            UserRole::TransportPartner => $this->driverData($user),
            default                    => $this->senderData($user),
        };

        return view('dashboard', $data);
    }

    private function adminData(): array
    {
        // Aggregate cached for 5 min — replaces 7 separate live queries per page load.
        // The cache is busted automatically when a driver's trust_tier or is_active changes
        // via an Eloquent observer (see TransporterProfile model) — for now TTL is sufficient.
        // Cache as array — never serialize Eloquent model objects into cache.
        $driverStats = Cache::remember('dashboard.driver_stats', 300, fn () =>
            TransporterProfile::selectRaw("
                COUNT(*) as total_drivers,
                COUNT(CASE WHEN is_active THEN 1 END) as active_drivers,
                COUNT(CASE WHEN trust_tier = ? THEN 1 END) as pending_review,
                COUNT(CASE WHEN trust_tier = ? THEN 1 END) as verified_drivers,
                COUNT(CASE WHEN trust_tier = ? THEN 1 END) as reviewed_drivers,
                COUNT(CASE WHEN trust_tier = ? THEN 1 END) as id_submitted_drivers
            ", [
                TrustTier::Unverified->value,
                TrustTier::Verified->value,
                TrustTier::ManuallyReviewed->value,
                TrustTier::IdSubmitted->value,
            ])->first()->toArray()
        );

        $totalOrders     = Cache::remember('dashboard.total_orders', 120, fn () => Task::count());
        $totalDrivers    = (int) $driverStats['total_drivers'];
        $activeDrivers   = (int) $driverStats['active_drivers'];
        $pendingReview   = (int) $driverStats['pending_review'];
        $verifiedDrivers = (int) $driverStats['verified_drivers'];
        $reviewedDrivers = (int) $driverStats['reviewed_drivers'];
        $idSubmittedDrivers = (int) $driverStats['id_submitted_drivers'];

        $recentOrders = Task::select(['id','order_number','status','pickup_address','dropoff_address','user_id','created_at'])
            ->with('user:id,name')
            ->latest()
            ->limit(10)
            ->get();

        return compact(
            'totalOrders', 'totalDrivers', 'activeDrivers',
            'pendingReview', 'verifiedDrivers', 'reviewedDrivers',
            'idSubmittedDrivers', 'recentOrders'
        );
    }

    private function driverData(User $user): array
    {
        $profile = $user->transporterProfile;
        $driverId = $profile?->id;

        $taskStats = Cache::remember("dashboard.driver_stats.{$driverId}", 120, fn () =>
            Task::where('assigned_driver_id', $driverId)
                ->selectRaw("COUNT(*) as total, COUNT(CASE WHEN status = 'delivered' THEN 1 END) as completed")
                ->first()
                ->toArray()
        );

        $assignedTasks  = (int) $taskStats['total'];
        $completedTasks = (int) $taskStats['completed'];

        $recentOrders = Task::where('assigned_driver_id', $driverId)
            ->latest()
            ->limit(8)
            ->get();

        return compact('profile', 'assignedTasks', 'completedTasks', 'recentOrders');
    }

    private function senderData(User $user): array
    {
        $orderStats = Cache::remember("dashboard.sender_stats.{$user->id}", 120, fn () =>
            Task::where('user_id', $user->id)
                ->selectRaw("
                    COUNT(*) as total,
                    COUNT(CASE WHEN status IN ('posted','assigned','in_progress') THEN 1 END) as pending,
                    COUNT(CASE WHEN status = 'delivered' THEN 1 END) as delivered,
                    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled
                ")->first()
                ->toArray()
        );

        $totalOrders     = (int) $orderStats['total'];
        $pendingOrders   = (int) $orderStats['pending'];
        $deliveredOrders = (int) $orderStats['delivered'];
        $cancelledOrders = (int) $orderStats['cancelled'];

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
