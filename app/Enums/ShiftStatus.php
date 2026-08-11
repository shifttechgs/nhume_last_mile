<?php

namespace App\Enums;

enum ShiftStatus: string
{
    case Scheduled = 'scheduled';
    case Active    = 'active';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
