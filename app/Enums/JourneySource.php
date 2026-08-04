<?php

namespace App\Enums;

enum JourneySource: string
{
    case AdminSeeded = 'admin_seeded';
    case TransporterDirect = 'transporter_direct';
    case Import = 'import';
}
