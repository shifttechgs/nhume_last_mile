<?php

namespace App\Enums;

enum ParcelStatus: string
{
    case Draft = 'draft';
    case Posted = 'posted';
    case Matched = 'matched';
    case InTransit = 'in_transit';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
}
