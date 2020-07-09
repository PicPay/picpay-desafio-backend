<?php

namespace App\Providers\Transfer;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\Transfer\TransferRepository;
use App\Repositories\Contracts\Transfer\TransferRepositoryContract;

class TransferRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TransferRepositoryContract::class,
            TransferRepository::class
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
