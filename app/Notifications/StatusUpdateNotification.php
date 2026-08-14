<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Channels\TwilioSmsChannel;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Notifications\Notification;

final class StatusUpdateNotification extends Notification
{
    public function __construct(
        private readonly Task       $task,
        private readonly TaskStatus $newStatus,
        private readonly string     $recipient, // 'sender' | 'recipient'
    ) {}

    public function via(mixed $notifiable): array
    {
        return [TwilioSmsChannel::class];
    }

    public function toSms(mixed $notifiable): string
    {
        $order    = $this->task->order_number;
        $trackUrl = url("/track/{$order}");

        return match ([$this->newStatus, $this->recipient]) {
            [TaskStatus::Assigned, 'sender'] =>
                "Good news! A driver has been assigned to your Nhume order.\nOrder: {$order}\nTrack: {$trackUrl}",

            [TaskStatus::InProgress, 'recipient'] =>
                "Your Nhume parcel is on the way, {$this->task->recipient_name}!\nOrder: {$order}\nTrack live: {$trackUrl}",

            [TaskStatus::InProgress, 'sender'] =>
                "Your Nhume parcel is now in transit.\nOrder: {$order}\nTrack: {$trackUrl}",

            [TaskStatus::Delivered, 'sender'] =>
                "Your Nhume parcel {$order} was delivered successfully. Thank you for using Nhume!",

            [TaskStatus::Delivered, 'recipient'] =>
                "Your Nhume parcel has arrived, {$this->task->recipient_name}! Order: {$order}",

            [TaskStatus::Cancelled, 'sender'] =>
                "Your Nhume order {$order} has been cancelled. Reply HELP or visit nhume.co.zw for support.",

            default => "Update on your Nhume order {$order}: {$this->newStatus->label()}. Track: {$trackUrl}",
        };
    }
}
