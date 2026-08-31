<?php

namespace App\Http\Controllers;

use App\Enums\JourneyStatus;
use App\Models\DeliveryRoute;
use App\Models\Journey;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JourneysController extends Controller
{
    public function index(Request $request): View
    {
        $routes = DeliveryRoute::where('is_active', true)
            ->orderBy('origin_city')
            ->get();

        $query = Journey::with(['route', 'transporter.user'])
            ->whereIn('status', [JourneyStatus::Scheduled->value, JourneyStatus::InProgress->value])
            ->where('departs_at', '>=', now());

        if ($request->filled('route_id')) {
            $query->where('route_id', $request->input('route_id'));
        }

        if ($request->filled('date')) {
            $query->whereDate('departs_at', $request->input('date'));
        }

        $journeys = $query->orderBy('departs_at')->paginate(12)->withQueryString();

        return view('pages.journeys', compact('journeys', 'routes'));
    }
}
