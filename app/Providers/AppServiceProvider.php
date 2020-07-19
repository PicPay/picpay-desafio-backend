<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->queryLog();
    }

    private function queryLog(): void
    {
        if (config('app.enable_query_log', false)) {
            DB::listen(function ($query) {
                Log::info('QUERY_LOG', [$query->sql, $query->bindings]);
            });
        }
    }
}
