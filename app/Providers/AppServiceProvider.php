<?php

namespace App\Providers;

use App\Channels\TwilioSmsChannel;
use App\Events\TaskCreated;
use App\Events\TaskStatusChanged;
use App\Listeners\SendOrderCreatedNotifications;
use App\Listeners\SendStatusChangeNotifications;
use App\Models\Task;
use App\Observers\TaskObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TwilioSmsChannel::class, function () {
            return new TwilioSmsChannel(
                twilio: new Client(
                    username: config('services.twilio.sid'),
                    password: config('services.twilio.token'),
                ),
                from: config('services.twilio.from'),
            );
        });
    }

    public function boot(): void
    {
        Task::observe(TaskObserver::class);

        Event::listen(TaskCreated::class,       SendOrderCreatedNotifications::class);
        Event::listen(TaskStatusChanged::class, SendStatusChangeNotifications::class);
    }
}
