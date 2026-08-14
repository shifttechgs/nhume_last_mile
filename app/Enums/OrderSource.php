<?php

namespace App\Enums;

enum OrderSource: string
{
    case Online  = 'online';
    case InStore = 'in_store';
    case Admin   = 'admin';
}
