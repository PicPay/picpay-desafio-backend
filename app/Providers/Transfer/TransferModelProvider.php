<?php

namespace App\Providers\Transfer;

use App\Models\Transfer\Transfer;
use App\Observers\TransferObserver;
use Illuminate\Support\ServiceProvider;

class TransferModelProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Transfer::observe(TransferObserver::class);
    }
}
