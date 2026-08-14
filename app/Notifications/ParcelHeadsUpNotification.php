<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Channels\TwilioSmsChannel;
use App\Models\Task;
use Illuminate\Notifications\Notification;

final class ParcelHeadsUpNotification extends Notification
{
    public function __construct(
        private readonly Task $task,
    ) {}

    public function via(mixed $notifiable): array
    {
        return [TwilioSmsChannel::class];
    }

    public function toSms(mixed $notifiable): string
    {
        $trackUrl = url("/track/{$this->task->order_number}");

        return implode("\n", [
            "Hi {$this->task->recipient_name}! Someone is sending you a parcel via Nhume.",
            "Order: {$this->task->order_number}",
            "Track your delivery: {$trackUrl}",
            "You'll get another message when it's on the way.",
        ]);
    }
}
