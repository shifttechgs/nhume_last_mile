<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Draft      = 'draft';
    case Posted     = 'posted';
    case Assigned   = 'assigned';
    case InProgress = 'in_progress';
    case Delivered  = 'delivered';
    case Cancelled  = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Draft      => 'Draft',
            self::Posted     => 'Order received',
            self::Assigned   => 'Driver assigned',
            self::InProgress => 'On the way',
            self::Delivered  => 'Delivered',
            self::Cancelled  => 'Cancelled',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Draft      => 'Your order is being prepared.',
            self::Posted     => 'We have received your order and are finding a driver.',
            self::Assigned   => 'A driver has been assigned and will collect your parcel shortly.',
            self::InProgress => 'Your parcel is on its way to the recipient.',
            self::Delivered  => 'Your parcel has been delivered successfully.',
            self::Cancelled  => 'This order has been cancelled.',
        };
    }

    /** Returns the ordered steps for the progress timeline (excludes Draft and Cancelled). */
    public static function timeline(): array
    {
        return [self::Posted, self::Assigned, self::InProgress, self::Delivered];
    }

    /** Whether this status appears at or after $other in the normal flow. */
    public function isAtOrAfter(self $other): bool
    {
        $order = [
            self::Draft->value      => 0,
            self::Posted->value     => 1,
            self::Assigned->value   => 2,
            self::InProgress->value => 3,
            self::Delivered->value  => 4,
            self::Cancelled->value  => 99,
        ];

        return ($order[$this->value] ?? 0) >= ($order[$other->value] ?? 0);
    }
}
