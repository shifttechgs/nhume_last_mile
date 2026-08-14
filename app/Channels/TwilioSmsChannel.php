<?php

declare(strict_types=1);

namespace App\Channels;

use App\Support\PhoneNormalizer;
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
        $raw = $notifiable->routeNotificationFor('twilio_sms', $notification);

        if (empty($raw)) {
            return;
        }

        $to = PhoneNormalizer::toE164($raw);

        if ($to === null) {
            Log::warning('Twilio SMS skipped — could not normalise number', ['raw' => $raw]);
            return;
        }

        $message = $notification->toSms($notifiable);

        try {
            $this->twilio->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);

            Log::info('Twilio SMS sent', ['to' => $to]);
        } catch (\Throwable $e) {
            Log::error('Twilio SMS failed', [
                'to'    => $to,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
