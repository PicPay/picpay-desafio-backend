<?php

namespace App\Providers\Transfer;

use App\Services\Contracts\Transfer\TransferServiceContract;
use App\Services\Transfer\TransferService;
use Illuminate\Support\ServiceProvider;

class TransferServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TransferServiceContract::class,
            TransferService::class
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
