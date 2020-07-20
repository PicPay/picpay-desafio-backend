<?php
namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use Model\MessageQueue\Repositories\MessageQueueRepository;
use Model\MessageQueue\Repositories\MessageQueueRepositoryInterface;

class MessageQueueRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MessageQueueRepositoryInterface::class,
            MessageQueueRepository::class
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
