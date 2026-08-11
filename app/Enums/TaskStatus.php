<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Draft     = 'draft';
    case Posted    = 'posted';
    case Assigned  = 'assigned';
    case InProgress = 'in_progress';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
}
