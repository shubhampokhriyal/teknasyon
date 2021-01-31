<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\SubscriptionChange;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\Started;
use App\Events\Renewed;
use App\Events\Canceled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Started::class => [
            // SendEmailVerificationNotification::class,
            SubscriptionChange::class,
        ],
        Renewed::class => [
            // SendEmailVerificationNotification::class,
            SubscriptionChange::class,
        ],
        Canceled::class => [
            // SendEmailVerificationNotification::class,
            SubscriptionChange::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
