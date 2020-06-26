<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\TransactionEvent::class => [
            0 => \App\Listeners\Transaction\ValidatorListener::class,
            1 => \App\Listeners\Transaction\AuthorizatorListener::class,
            2 => \App\Listeners\Transaction\NotificationListener::class,
        ],
    ];
}
