<?php

namespace App\Providers\Authorization;

use App\Services\Authorization\AuthorizationService;
use App\Services\Contracts\Authorization\AuthorizationServiceContract;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AuthorizationServiceContract::class,
            AuthorizationService::class
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
