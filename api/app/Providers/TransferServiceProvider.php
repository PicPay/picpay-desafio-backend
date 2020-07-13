<?php

namespace App\Providers;

use App\Services\TransferService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * Class TransferServiceProvider
 * @package App\Providers
 */
class TransferServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'TransferFacade',
            function () {
                $authorization = Config::get('transfer.authorization');
                $class = $authorization['class'];
                $args = $authorization['args'] ?? [];
                $authorizationService = new $class(...$args);

                return new TransferService($authorizationService);
            }
        );
    }
}
