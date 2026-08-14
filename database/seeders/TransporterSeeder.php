<?php

namespace Database\Seeders;

use App\Enums\DriverSource;
use App\Enums\TrustTier;
use App\Enums\UserRole;
use App\Models\TransporterProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TransporterSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = [
            [
                'name'         => 'Tafadzwa Moyo',
                'email'        => 'tafadzwa.moyo@nhume.co.zw',
                'phone'        => '+263771234567',
                'bio'          => 'Based in Harare, doing the Harare–Bulawayo run every Friday and Sunday. Safe, punctual, 5 years on the road.',
                'trust_tier'   => TrustTier::Verified,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
            [
                'name'         => 'Blessing Ncube',
                'email'        => 'blessing.ncube@nhume.co.zw',
                'phone'        => '+263772345678',
                'bio'          => 'Bulawayo resident. Regular trips to Gweru and Harare for business. Happy to carry parcels both ways.',
                'trust_tier'   => TrustTier::Verified,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
            [
                'name'         => 'Chiedza Chirwa',
                'email'        => 'chiedza.chirwa@nhume.co.zw',
                'phone'        => '+263773456789',
                'bio'          => 'Travels Harare–Mutare most weekends visiting family. Toyota Land Cruiser with plenty of boot space.',
                'trust_tier'   => TrustTier::ManuallyReviewed,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
            [
                'name'         => 'Simbarashe Dube',
                'email'        => 'simba.dube@nhume.co.zw',
                'phone'        => '+263774567890',
                'bio'          => 'Long-haul transporter. Bulawayo–Victoria Falls weekly, sometimes via Hwange.',
                'trust_tier'   => TrustTier::ManuallyReviewed,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
            [
                'name'         => 'Ruvimbo Sithole',
                'email'        => 'ruvimbo.sithole@nhume.co.zw',
                'phone'        => '+263775678901',
                'bio'          => 'Harare–Gweru corridor. Retired teacher, now travelling for church ministry. Very careful with packages.',
                'trust_tier'   => TrustTier::ManuallyReviewed,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
            [
                'name'         => 'Farai Mutasa',
                'email'        => 'farai.mutasa@nhume.co.zw',
                'phone'        => '+263776789012',
                'bio'          => 'Runs a small transport business between Harare and Masvingo. Can handle larger parcels.',
                'trust_tier'   => TrustTier::IdSubmitted,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
            [
                'name'         => 'Tatenda Mhlanga',
                'email'        => 'tatenda.mhlanga@nhume.co.zw',
                'phone'        => '+263777890123',
                'bio'          => 'Harare based. Travel to Bulawayo for stock twice a month. Comfortable carrying clothes and electronics.',
                'trust_tier'   => TrustTier::IdSubmitted,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
            [
                'name'         => 'Nyasha Gumbo',
                'email'        => 'nyasha.gumbo@nhume.co.zw',
                'phone'        => '+263778901234',
                'bio'          => 'Young entrepreneur, making regular runs Harare–Mutare for resale goods. Honest and reliable.',
                'trust_tier'   => TrustTier::Unverified,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
            [
                'name'         => 'Admire Banda',
                'email'        => 'admire.banda@nhume.co.zw',
                'phone'        => '+263779012345',
                'bio'          => 'New to Nhume. Drive a Nissan NP300 bakkie between Harare and Kariba monthly.',
                'trust_tier'   => TrustTier::Unverified,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
            [
                'name'         => 'Patience Zvenyika',
                'email'        => 'patience.zvenyika@nhume.co.zw',
                'phone'        => '+263770123456',
                'bio'          => 'Nurse in Bulawayo, travelling home to Harare every other weekend. Trustworthy, neat, careful.',
                'trust_tier'   => TrustTier::Unverified,
                'driver_source'=> DriverSource::IndependentTransporter,
                'service_types'=> ['intercity_parcel'],
            ],
        ];

        foreach ($drivers as $data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password'),
                'role'     => UserRole::TransportPartner,
            ]);

            TransporterProfile::create([
                'user_id'       => $user->id,
                'phone'         => $data['phone'],
                'whatsapp'      => $data['phone'],
                'bio'           => $data['bio'],
                'trust_tier'    => $data['trust_tier'],
                'driver_source' => $data['driver_source'],
                'service_types' => $data['service_types'],
                'is_active'     => true,
            ]);
        }
    }
}
