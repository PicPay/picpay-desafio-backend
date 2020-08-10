<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use Model\Transactions\Repositories\TransactionsRepository;
use Model\Transactions\Repositories\TransactionsRepositoryInterface;

class TransactionsRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TransactionsRepositoryInterface::class,
            TransactionsRepository::class
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
