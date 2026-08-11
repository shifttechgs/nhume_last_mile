<?php

namespace App\Enums;

enum FleetAssetStatus: string
{
    case Available   = 'available';
    case Assigned    = 'assigned';
    case Maintenance = 'maintenance';
    case Retired     = 'retired';
}
