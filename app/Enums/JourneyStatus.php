<?php

namespace App\Enums;

enum JourneyStatus: string
{
    case AdminDraft = 'admin_draft';
    case Scheduled = 'scheduled';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
