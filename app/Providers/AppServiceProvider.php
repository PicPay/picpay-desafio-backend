<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Transaction\TransactionInterface;
use App\Repositories\Transaction\TransactionRepository;
use App\Interfaces\User\UserWalletInterface;
use App\Repositories\User\UserWalletRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        $this->app->bind(UserWalletInterface::class, UserWalletRepository::class);
    }
}
