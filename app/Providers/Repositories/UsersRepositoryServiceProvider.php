<?php
namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use Model\Users\Repositories\UsersRepositoryInterface;
use Model\Users\Repositories\UsersRepository;

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
            UsersRepositoryInterface::class,
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
