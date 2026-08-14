<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Notifications\OrderConfirmedNotification;
use App\Notifications\ParcelHeadsUpNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

final class SendOrderCreatedNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries   = 3;
    public int $backoff = 30;

    public function handle(TaskCreated $event): void
    {
        $task = $event->task;

        if (filled($task->sender_phone)) {
            Notification::route('twilio_sms', $task->sender_phone)
                ->notify(new OrderConfirmedNotification($task));
        }

        if (filled($task->recipient_phone)) {
            Notification::route('twilio_sms', $task->recipient_phone)
                ->notify(new ParcelHeadsUpNotification($task));
        }
    }

    public function failed(TaskCreated $event, \Throwable $exception): void
    {
        Log::error('SendOrderCreatedNotifications failed', [
            'order_number' => $event->task->order_number,
            'error'        => $exception->getMessage(),
        ]);
    }
}
