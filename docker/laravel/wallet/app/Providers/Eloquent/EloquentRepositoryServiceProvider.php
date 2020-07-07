<?php

namespace App\Providers\Eloquent;

use App\Repositories\Contracts\EloquentRepositoryInterface;
use App\Repositories\EloquentRepository;
use Illuminate\Support\ServiceProvider;

class EloquentRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, EloquentRepository::class);
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
