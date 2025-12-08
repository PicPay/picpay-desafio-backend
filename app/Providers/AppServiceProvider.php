<?php

namespace PicPay\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        // Disable SSL verification for local and testing environments in an HTTP client
        $this->app->bind(
            abstract: PendingRequest::class,
            concrete: fn (Application $app) => $app->get(Http::class)->withOptions(
                options: [
                    'verify' => ! $app->environment(['local', 'testing']),
                    'timeout' => 30,
                    'retry' => 3,
                ]
            )
        );
    }

    public function boot(): void {}
}
