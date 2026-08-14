<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Channels\TwilioSmsChannel;
use App\Models\Task;
use Illuminate\Notifications\Notification;

final class OrderConfirmedNotification extends Notification
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
            "Your Nhume order is confirmed!",
            "Order: {$this->task->order_number}",
            "Track: {$trackUrl}",
            "We'll update you when a driver is assigned.",
        ]);
    }
}
