<?php

namespace Database\Seeders;

use App\Enums\JourneySource;
use App\Enums\JourneyStatus;
use App\Models\DeliveryRoute;
use App\Models\Journey;
use App\Models\TransporterProfile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JourneySeeder extends Seeder
{
    public function run(): void
    {
        // ── Add missing corridors ──────────────────────────────────
        $extraRoutes = [
            [
                'origin_city'          => 'Harare',
                'destination_city'     => 'Bulawayo',
                'origin_code'          => 'HRE',
                'destination_code'     => 'BUQ',
                'distance_km'          => 439,
                'typical_duration_mins'=> 300,
                'is_active'            => true,
            ],
            [
                'origin_city'          => 'Bulawayo',
                'destination_city'     => 'Harare',
                'origin_code'          => 'BUQ',
                'destination_code'     => 'HRE',
                'distance_km'          => 439,
                'typical_duration_mins'=> 300,
                'is_active'            => true,
            ],
            [
                'origin_city'          => 'Harare',
                'destination_city'     => 'Mutare',
                'origin_code'          => 'HRE',
                'destination_code'     => 'UTA',
                'distance_km'          => 263,
                'typical_duration_mins'=> 210,
                'is_active'            => true,
            ],
            [
                'origin_city'          => 'Harare',
                'destination_city'     => 'Gweru',
                'origin_code'          => 'HRE',
                'destination_code'     => 'GWE',
                'distance_km'          => 275,
                'typical_duration_mins'=> 225,
                'is_active'            => true,
            ],
            [
                'origin_city'          => 'Bulawayo',
                'destination_city'     => 'Victoria Falls',
                'origin_code'          => 'BUQ',
                'destination_code'     => 'VFA',
                'distance_km'          => 439,
                'typical_duration_mins'=> 360,
                'is_active'            => true,
            ],
            [
                'origin_city'          => 'Harare',
                'destination_city'     => 'Masvingo',
                'origin_code'          => 'HRE',
                'destination_code'     => 'MVZ',
                'distance_km'          => 292,
                'typical_duration_mins'=> 240,
                'is_active'            => true,
            ],
        ];

        foreach ($extraRoutes as $r) {
            DeliveryRoute::firstOrCreate(
                ['origin_city' => $r['origin_city'], 'destination_city' => $r['destination_city']],
                $r
            );
        }

        // ── Resolve route IDs ──────────────────────────────────────
        $route = fn (string $from, string $to): int =>
            DeliveryRoute::where('origin_city', $from)
                ->where('destination_city', $to)
                ->value('id');

        // ── Resolve transporter profile IDs by email ───────────────
        $tp = fn (string $email): int =>
            TransporterProfile::whereHas('user', fn ($q) => $q->where('email', $email))->value('id');

        // ── Date helpers ───────────────────────────────────────────
        $next = fn (string $day, string $time = '06:00'): Carbon =>
            Carbon::now()->next($day)->setTimeFromTimeString($time);

        $in = fn (int $days, string $time = '06:00'): Carbon =>
            Carbon::now()->addDays($days)->setTimeFromTimeString($time);

        $ago = fn (int $days, string $time = '06:00'): Carbon =>
            Carbon::now()->subDays($days)->setTimeFromTimeString($time);

        // ── Journey definitions ────────────────────────────────────
        $journeys = [

            // ── Tafadzwa Moyo (Verified) — Harare↔Bulawayo every Fri & Sun
            [
                'transporter_profile_id' => $tp('tafadzwa.moyo@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Bulawayo'),
                'departs_at'             => $next('Friday', '05:30'),
                'available_weight_kg'    => 100,
                'available_slots'        => 5,
                'price_per_kg'           => 2.50,
                'min_price'              => 6.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => null,
            ],
            [
                'transporter_profile_id' => $tp('tafadzwa.moyo@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Bulawayo'),
                'departs_at'             => $next('Sunday', '05:30'),
                'available_weight_kg'    => 100,
                'available_slots'        => 5,
                'price_per_kg'           => 2.50,
                'min_price'              => 6.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => null,
            ],

            // ── Blessing Ncube (Verified) — Bulawayo↔Harare
            [
                'transporter_profile_id' => $tp('blessing.ncube@nhume.co.zw'),
                'route_id'               => $route('Bulawayo', 'Harare'),
                'departs_at'             => $next('Saturday', '06:00'),
                'available_weight_kg'    => 80,
                'available_slots'        => 4,
                'price_per_kg'           => 2.50,
                'min_price'              => 6.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => 'No liquids please.',
            ],
            [
                'transporter_profile_id' => $tp('blessing.ncube@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Bulawayo'),
                'departs_at'             => $in(10, '05:30'),
                'available_weight_kg'    => 80,
                'available_slots'        => 4,
                'price_per_kg'           => 2.50,
                'min_price'              => 6.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => null,
            ],

            // ── Chiedza Chirwa (Reviewed) — Harare→Mutare weekends
            [
                'transporter_profile_id' => $tp('chiedza.chirwa@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Mutare'),
                'departs_at'             => $next('Sunday', '07:00'),
                'available_weight_kg'    => 120,
                'available_slots'        => 5,
                'price_per_kg'           => 2.00,
                'min_price'              => 5.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => 'Fragile items welcome. Land Cruiser with padded boot.',
            ],
            [
                'transporter_profile_id' => $tp('chiedza.chirwa@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Mutare'),
                'departs_at'             => $in(14, '07:00'),
                'available_weight_kg'    => 120,
                'available_slots'        => 5,
                'price_per_kg'           => 2.00,
                'min_price'              => 5.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => null,
            ],

            // ── Simbarashe Dube (Reviewed) — Bulawayo→Vic Falls weekly
            [
                'transporter_profile_id' => $tp('simba.dube@nhume.co.zw'),
                'route_id'               => $route('Bulawayo', 'Victoria Falls'),
                'departs_at'             => $next('Monday', '05:00'),
                'available_weight_kg'    => 200,
                'available_slots'        => 8,
                'price_per_kg'           => 3.50,
                'min_price'              => 10.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => 'Will stop in Hwange if needed.',
            ],

            // ── Ruvimbo Sithole (Reviewed) — Harare→Gweru
            [
                'transporter_profile_id' => $tp('ruvimbo.sithole@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Gweru'),
                'departs_at'             => $next('Saturday', '08:00'),
                'available_weight_kg'    => 60,
                'available_slots'        => 3,
                'price_per_kg'           => 1.50,
                'min_price'              => 4.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => null,
            ],
            [
                'transporter_profile_id' => $tp('ruvimbo.sithole@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Gweru'),
                'departs_at'             => $in(12, '08:00'),
                'available_weight_kg'    => 60,
                'available_slots'        => 3,
                'price_per_kg'           => 1.50,
                'min_price'              => 4.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => null,
            ],

            // ── Farai Mutasa (ID Submitted) — Harare→Masvingo, negotiate price
            [
                'transporter_profile_id' => $tp('farai.mutasa@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Masvingo'),
                'departs_at'             => $next('Tuesday', '06:30'),
                'available_weight_kg'    => 250,
                'available_slots'        => 10,
                'price_per_kg'           => null,
                'min_price'              => null,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => 'Price negotiable. Can handle large boxes and furniture.',
            ],

            // ── Tatenda Mhlanga (ID Submitted) — Harare→Bulawayo for stock runs
            [
                'transporter_profile_id' => $tp('tatenda.mhlanga@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Bulawayo'),
                'departs_at'             => $in(8, '05:30'),
                'available_weight_kg'    => 80,
                'available_slots'        => 4,
                'price_per_kg'           => 2.50,
                'min_price'              => 6.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => 'Comfortable carrying clothes and electronics.',
            ],

            // ── Nyasha Gumbo (Unverified) — Harare→Mutare for resale goods
            [
                'transporter_profile_id' => $tp('nyasha.gumbo@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Mutare'),
                'departs_at'             => $in(6, '07:00'),
                'available_weight_kg'    => 50,
                'available_slots'        => 3,
                'price_per_kg'           => 1.80,
                'min_price'              => 4.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => null,
            ],

            // ── Admire Banda (Unverified) — Harare→Bulawayo bakkie, negotiate
            [
                'transporter_profile_id' => $tp('admire.banda@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Bulawayo'),
                'departs_at'             => $in(15, '06:00'),
                'available_weight_kg'    => 300,
                'available_slots'        => 12,
                'price_per_kg'           => null,
                'min_price'              => null,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => 'NP300 bakkie with canopy. Great for bulk goods.',
            ],

            // ── Patience Zvenyika (Unverified) — Bulawayo→Harare every other weekend
            [
                'transporter_profile_id' => $tp('patience.zvenyika@nhume.co.zw'),
                'route_id'               => $route('Bulawayo', 'Harare'),
                'departs_at'             => $in(5, '07:00'),
                'available_weight_kg'    => 40,
                'available_slots'        => 2,
                'price_per_kg'           => 2.00,
                'min_price'              => 5.00,
                'status'                 => JourneyStatus::Scheduled,
                'notes'                  => null,
            ],

            // ── In Progress ───────────────────────────────────────
            [
                'transporter_profile_id' => $tp('tafadzwa.moyo@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Bulawayo'),
                'departs_at'             => $ago(1, '05:30'),
                'available_weight_kg'    => 100,
                'available_slots'        => 5,
                'price_per_kg'           => 2.50,
                'min_price'              => 6.00,
                'status'                 => JourneyStatus::InProgress,
                'notes'                  => null,
            ],
            [
                'transporter_profile_id' => $tp('chiedza.chirwa@nhume.co.zw'),
                'route_id'               => $route('Harare', 'Mutare'),
                'departs_at'             => $ago(3, '07:00'),
                'available_weight_kg'    => 120,
                'available_slots'        => 5,
                'price_per_kg'           => 2.00,
                'min_price'              => 5.00,
                'status'                 => JourneyStatus::InProgress,
                'notes'                  => null,
            ],

            // ── Completed ─────────────────────────────────────────
            [
                'transporter_profile_id' => $tp('blessing.ncube@nhume.co.zw'),
                'route_id'               => $route('Bulawayo', 'Harare'),
                'departs_at'             => $ago(14, '06:00'),
                'available_weight_kg'    => 80,
                'available_slots'        => 4,
                'price_per_kg'           => 2.50,
                'min_price'              => 6.00,
                'status'                 => JourneyStatus::Completed,
                'notes'                  => null,
            ],
            [
                'transporter_profile_id' => $tp('simba.dube@nhume.co.zw'),
                'route_id'               => $route('Bulawayo', 'Victoria Falls'),
                'departs_at'             => $ago(21, '05:00'),
                'available_weight_kg'    => 200,
                'available_slots'        => 8,
                'price_per_kg'           => 3.50,
                'min_price'              => 10.00,
                'status'                 => JourneyStatus::Completed,
                'notes'                  => null,
            ],
        ];

        foreach ($journeys as $data) {
            Journey::create([
                ...$data,
                'source'     => JourneySource::TransporterDirect,
                'arrives_at' => null,
            ]);
        }
    }
}
