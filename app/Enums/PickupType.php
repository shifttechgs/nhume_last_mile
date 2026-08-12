<?php

namespace App\Enums;

enum PickupType: string
{
    case WalkIn          = 'walk_in';
    case BikerCollection = 'biker_collection';

    public function label(): string
    {
        return match($this) {
            self::WalkIn          => 'Drop at shop',
            self::BikerCollection => 'Biker picks up',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::WalkIn          => 'Bring your parcel to the nearest Nhume shop. Faster and cheaper.',
            self::BikerCollection => 'We send a biker to your location to collect the parcel.',
        };
    }

    public function collectionFee(): float
    {
        return match($this) {
            self::WalkIn          => 0.00,
            self::BikerCollection => 2.00,
        };
    }
}
