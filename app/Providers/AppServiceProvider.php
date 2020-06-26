<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Log;
use Monolog\Handler\StreamHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        //log to console for development purpouses and work with tests
        Log::pushHandler(new StreamHandler('php://stdout'));
    }
}
