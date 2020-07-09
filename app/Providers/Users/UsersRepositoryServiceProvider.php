<?php

namespace App\Providers\Users;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\Users\UsersRepository;
use App\Repositories\Contracts\Users\UsersRepositoryContract;

class UsersRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UsersRepositoryContract::class,
            UsersRepository::class
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
