<?php

declare(strict_types=1);

namespace App\Support;

final class PhoneNormalizer
{
    /**
     * Normalise a phone number to E.164 format for Twilio.
     *
     * Supported shorthand formats:
     *   0814303023  (10-digit SA)  → +27814303023
     *   07XXXXXXXX  (10-digit ZW)  → +26371XXXXXXX  (07 → +2637)
     *   +27...  /  +263...         → returned as-is
     *
     * Returns null if the number cannot be resolved.
     */
    public static function toE164(string $phone, string $defaultCountry = 'ZW'): ?string
    {
        $digits = preg_replace('/\D/', '', $phone);

        // Already has country code prefix in original string
        if (str_starts_with(ltrim($phone), '+')) {
            return '+' . $digits;
        }

        // 11-digit: assume country code already without +
        if (strlen($digits) === 11) {
            return '+' . $digits;
        }

        // 10-digit local number — apply country default
        if (strlen($digits) === 10 && str_starts_with($digits, '0')) {
            $national = substr($digits, 1); // strip leading 0

            return match ($defaultCountry) {
                'ZA'    => '+27' . $national,
                'ZW'    => '+263' . $national,
                default => '+27' . $national, // SA as fallback for testing
            };
        }

        return null;
    }
}
