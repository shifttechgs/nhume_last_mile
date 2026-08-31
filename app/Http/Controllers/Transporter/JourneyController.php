<?php

namespace App\Http\Controllers\Transporter;

use App\Enums\JourneySource;
use App\Enums\JourneyStatus;
use App\Http\Controllers\Controller;
use App\Models\DeliveryRoute;
use App\Models\Journey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JourneyController extends Controller
{
    public function index(): View
    {
        $profile = Auth::user()->transporterProfile;

        $journeys = Journey::where('transporter_profile_id', $profile->id)
            ->with('route')
            ->orderByDesc('departs_at')
            ->paginate(10)
            ->withQueryString();

        return view('transporter.journeys.index', compact('journeys', 'profile'));
    }

    public function create(): View
    {
        $routes = DeliveryRoute::where('is_active', true)
            ->orderBy('origin_city')
            ->get();

        return view('transporter.journeys.create', compact('routes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'route_id'            => ['required', 'exists:routes,id'],
            'departs_at'          => ['required', 'date', 'after:now'],
            'available_weight_kg' => ['nullable', 'numeric', 'min:0.1', 'max:9999'],
            'available_slots'     => ['required', 'integer', 'min:1', 'max:100'],
            'price_per_kg'        => ['nullable', 'numeric', 'min:0'],
            'min_price'           => ['nullable', 'numeric', 'min:0'],
            'notes'               => ['nullable', 'string', 'max:500'],
        ]);

        $profile = Auth::user()->transporterProfile;

        Journey::create([
            ...$validated,
            'transporter_profile_id' => $profile->id,
            'status'                 => JourneyStatus::Scheduled,
            'source'                 => JourneySource::TransporterDirect,
        ]);

        return redirect()->route('transporter.journeys.index')
            ->with('success', 'Journey posted. Senders can now book space on your trip.');
    }

    public function cancel(Journey $journey): RedirectResponse
    {
        abort_if($journey->transporter_profile_id !== Auth::user()->transporterProfile?->id, 403);
        abort_if($journey->status === JourneyStatus::Completed, 422, 'Cannot cancel a completed journey.');

        $journey->update(['status' => JourneyStatus::Cancelled]);

        return back()->with('success', 'Journey cancelled.');
    }
}
