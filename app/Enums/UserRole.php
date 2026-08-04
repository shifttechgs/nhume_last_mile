<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Sender = 'sender';
    case TransportPartner = 'transport_partner';
    case Business = 'business';
}
