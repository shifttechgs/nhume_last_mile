<?php

namespace App\Enums;

enum VehicleType: string
{
    case Bicycle    = 'bicycle';
    case Motorcycle = 'motorcycle';
    case Car        = 'car';
    case Minivan    = 'minivan';
    case Truck      = 'truck';

    public function label(): string
    {
        return match($this) {
            self::Bicycle    => 'Bicycle',
            self::Motorcycle => 'Motorcycle',
            self::Car        => 'Car',
            self::Minivan    => 'Minivan',
            self::Truck      => 'Truck',
        };
    }

    public function maxWeightKg(): float
    {
        return match($this) {
            self::Bicycle    => 20.0,
            self::Motorcycle => 50.0,
            self::Car        => 200.0,
            self::Minivan    => 500.0,
            self::Truck      => 5000.0,
        };
    }

    public function suitableFor(): array
    {
        return match($this) {
            self::Bicycle, self::Motorcycle => [ServiceType::LastMileDelivery, ServiceType::Errand],
            self::Car, self::Minivan, self::Truck => [ServiceType::IntercityParcel, ServiceType::LastMileDelivery],
        };
    }
}
