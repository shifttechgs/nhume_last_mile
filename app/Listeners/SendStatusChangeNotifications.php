<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\TaskStatus;
use App\Events\TaskStatusChanged;
use App\Notifications\StatusUpdateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

final class SendStatusChangeNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries   = 3;
    public int $backoff = 30;

    /** Which statuses trigger sender SMS */
    private const SENDER_STATUSES = [
        TaskStatus::Assigned,
        TaskStatus::InProgress,
        TaskStatus::Delivered,
        TaskStatus::Cancelled,
    ];

    /** Which statuses trigger recipient SMS */
    private const RECIPIENT_STATUSES = [
        TaskStatus::InProgress,
        TaskStatus::Delivered,
    ];

    public function handle(TaskStatusChanged $event): void
    {
        $task   = $event->task;
        $status = $event->newStatus;

        if (filled($task->sender_phone) && in_array($status, self::SENDER_STATUSES, strict: true)) {
            Notification::route('twilio_sms', $task->sender_phone)
                ->notify(new StatusUpdateNotification($task, $status, 'sender'));
        }

        if (filled($task->recipient_phone) && in_array($status, self::RECIPIENT_STATUSES, strict: true)) {
            Notification::route('twilio_sms', $task->recipient_phone)
                ->notify(new StatusUpdateNotification($task, $status, 'recipient'));
        }
    }

    public function failed(TaskStatusChanged $event, \Throwable $exception): void
    {
        Log::error('SendStatusChangeNotifications failed', [
            'order_number' => $event->task->order_number,
            'new_status'   => $event->newStatus->value,
            'error'        => $exception->getMessage(),
        ]);
    }
}
