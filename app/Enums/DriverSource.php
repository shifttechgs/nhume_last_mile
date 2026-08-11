<?php

namespace App\Enums;

enum DriverSource: string
{
    case NhumeFleet            = 'nhume_fleet';
    case IndependentBiker      = 'independent_biker';
    case IndependentTransporter = 'independent_transporter';

    public function label(): string
    {
        return match($this) {
            self::NhumeFleet             => 'Nhume Fleet',
            self::IndependentBiker       => 'Independent Biker',
            self::IndependentTransporter => 'Independent Transporter',
        };
    }
}
