<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use App\Events\Transaction\Validation;
use App\Listeners\Transaction\Authorization;
use App\Listeners\Transaction\Monetization;
use App\Listeners\Transaction\Notification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Validation::class => [
            Authorization::class,
            Monetization::class,
            Notification::class,
        ],
    ];
}
