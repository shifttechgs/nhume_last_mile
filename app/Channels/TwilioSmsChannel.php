<?php

declare(strict_types=1);

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

final class TwilioSmsChannel
{
    public function __construct(
        private readonly Client $twilio,
        private readonly string $from,
    ) {}

    public function send(mixed $notifiable, Notification $notification): void
    {
        $to = $notifiable->routeNotificationFor('twilio_sms', $notification);

        if (empty($to)) {
            return;
        }

        $message = $notification->toSms($notifiable);

        try {
            $this->twilio->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);
        } catch (\Throwable $e) {
            Log::error('Twilio SMS failed', [
                'to'    => $to,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
