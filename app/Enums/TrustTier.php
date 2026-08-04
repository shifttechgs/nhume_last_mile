<?php

namespace App\Enums;

enum TrustTier: string
{
    case Unverified = 'unverified';
    case ManuallyReviewed = 'manually_reviewed';
    case IdSubmitted = 'id_submitted';
    case Verified = 'verified';
}
