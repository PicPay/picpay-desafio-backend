<?php

namespace App\Providers\Services\Transfer;

use App\Services\Transfer\AddTransferService;
use App\Services\Transfer\AddTransferServiceInterface;
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
            AddTransferServiceInterface::class,
            AddTransferService::class
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
