<?php

namespace App\Http\Controllers;

use App\Enums\DriverSource;
use App\Enums\TrustTier;
use App\Enums\UserRole;
use App\Models\DeliveryRoute;
use App\Models\TransporterProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class TransporterApplicationController extends Controller
{
    public function show(): View
    {
        $routes = DeliveryRoute::where('is_active', true)
            ->orderBy('origin_city')
            ->get();

        return view('pages.partner', compact('routes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'phone'     => ['required', 'string', 'max:20'],
            'whatsapp'  => ['nullable', 'string', 'max:20'],
            'bio'       => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'phone'    => $data['phone'],
                'password' => Hash::make(str()->random(24)),
                'role'     => UserRole::TransportPartner,
            ]);

            TransporterProfile::create([
                'user_id'       => $user->id,
                'phone'         => $data['phone'],
                'whatsapp'      => $data['whatsapp'] ?? $data['phone'],
                'bio'           => $data['bio'] ?? null,
                'trust_tier'    => TrustTier::Unverified,
                'driver_source' => DriverSource::IndependentTransporter,
                'service_types' => ['intercity_parcel'],
                'is_active'     => true,
            ]);

            // Send password-setup email so they can log in once approved.
            Password::sendResetLink(['email' => $data['email']]);
        });

        return redirect()
            ->route('partner')
            ->with('applied', true);
    }
}
