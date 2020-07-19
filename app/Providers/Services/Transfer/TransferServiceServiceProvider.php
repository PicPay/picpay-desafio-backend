<?php

namespace App\Providers\Services\Transfer;

use App\Services\Transfer\TransferService;
use App\Services\Transfer\TransferServiceInterface;
use Illuminate\Support\ServiceProvider;


class TransferServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TransferServiceInterface::class,
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
