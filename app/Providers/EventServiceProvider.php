<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\OrderCreated;
use App\Listeners\OrderCreatedNotification;
use App\Listeners\OrderCreatedClientNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderShipped::class => [
            ShipmentDeliveryNotification::class,
            ShipmentDeliveredNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            OrderCreated::class,
            [OrderCreatedNotification::class, 'handle']
        );

        Event::listen(
            OrderCreated::class,
            [OrderCreatedClientNotification::class, 'handle']
        );

        Event::listen(
            ProviderUpdated::class,
            [ProviderUpdatedNotification::class, 'handle']
        );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
