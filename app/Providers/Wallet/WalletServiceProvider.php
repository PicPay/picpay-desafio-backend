<?php

namespace App\Providers\Wallet;

use App\Services\Contracts\Wallet\WalletServiceContract;
use App\Services\Wallet\WalletService;
use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            WalletServiceContract::class,
            WalletService::class
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
