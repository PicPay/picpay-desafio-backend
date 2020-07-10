<?php

namespace App\Providers\Notification;

use App\Repositories\Contracts\Notification\NotificationRepositoryContract;
use App\Repositories\Eloquent\Notification\NotificationRepository;
use Illuminate\Support\ServiceProvider;

class NotificationRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            NotificationRepositoryContract::class,
            NotificationRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
