<?php

namespace App\Enums;

enum ServiceType: string
{
    case IntercityParcel = 'intercity_parcel';
    case LastMileDelivery = 'last_mile_delivery';
    case Errand = 'errand';

    public function label(): string
    {
        return match($this) {
            self::IntercityParcel  => 'Intercity Parcel',
            self::LastMileDelivery => 'Local Delivery',
            self::Errand           => 'Errand',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::IntercityParcel  => 'Send parcels between cities on existing journeys.',
            self::LastMileDelivery => 'Same-day delivery within your city.',
            self::Errand           => 'Someone runs a task or errand on your behalf.',
        };
    }
}
