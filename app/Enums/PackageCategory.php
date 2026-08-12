<?php

namespace App\Enums;

enum PackageCategory: string
{
    case Documents   = 'documents';
    case Clothing    = 'clothing';
    case Electronics = 'electronics';
    case Food        = 'food';
    case Other       = 'other';

    public function label(): string
    {
        return match($this) {
            self::Documents   => 'Documents',
            self::Clothing    => 'Clothing',
            self::Electronics => 'Electronics',
            self::Food        => 'Food',
            self::Other       => 'Other',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Documents   => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            self::Clothing    => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
            self::Electronics => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
            self::Food        => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
            self::Other       => 'M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11',
        };
    }
}
