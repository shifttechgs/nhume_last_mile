<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryRoute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RouteController extends Controller
{
    public function index(): View
    {
        $routes = DeliveryRoute::orderBy('origin_city')->orderBy('destination_city')->get();

        return view('admin.routes.index', compact('routes'));
    }

    public function create(): View
    {
        return view('admin.routes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'origin_city'          => ['required', 'string', 'max:100'],
            'destination_city'     => ['required', 'string', 'max:100'],
            'origin_code'          => ['nullable', 'string', 'max:10'],
            'destination_code'     => ['nullable', 'string', 'max:10'],
            'distance_km'          => ['nullable', 'numeric', 'min:1'],
            'typical_duration_mins'=> ['nullable', 'integer', 'min:1'],
        ]);

        // Both directions
        DeliveryRoute::firstOrCreate(
            ['origin_city' => $data['origin_city'], 'destination_city' => $data['destination_city']],
            array_merge($data, ['is_active' => true])
        );

        if ($request->boolean('bidirectional')) {
            DeliveryRoute::firstOrCreate(
                ['origin_city' => $data['destination_city'], 'destination_city' => $data['origin_city']],
                [
                    'origin_code'          => $data['destination_code'] ?? null,
                    'destination_code'     => $data['origin_code'] ?? null,
                    'distance_km'          => $data['distance_km'] ?? null,
                    'typical_duration_mins'=> $data['typical_duration_mins'] ?? null,
                    'is_active'            => true,
                ]
            );
        }

        return redirect()
            ->route('admin.routes.index')
            ->with('success', "Route {$data['origin_city']} → {$data['destination_city']} added.");
    }

    public function edit(DeliveryRoute $route): View
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, DeliveryRoute $route): RedirectResponse
    {
        $data = $request->validate([
            'origin_city'          => ['required', 'string', 'max:100'],
            'destination_city'     => ['required', 'string', 'max:100'],
            'origin_code'          => ['nullable', 'string', 'max:10'],
            'destination_code'     => ['nullable', 'string', 'max:10'],
            'distance_km'          => ['nullable', 'numeric', 'min:1'],
            'typical_duration_mins'=> ['nullable', 'integer', 'min:1'],
            'is_active'            => ['boolean'],
        ]);

        $route->update($data);

        return redirect()
            ->route('admin.routes.index')
            ->with('success', "Route updated.");
    }

    public function toggleActive(DeliveryRoute $route): RedirectResponse
    {
        $route->update(['is_active' => !$route->is_active]);

        return back()->with('success', $route->is_active ? 'Route activated.' : 'Route deactivated.');
    }

    public function destroy(DeliveryRoute $route): RedirectResponse
    {
        $route->delete();

        return redirect()
            ->route('admin.routes.index')
            ->with('success', 'Route deleted.');
    }
}
