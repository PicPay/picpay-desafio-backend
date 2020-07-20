<?php

namespace App\Providers\Validators;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class TransactionValidatorsServiceProvider extends ServiceProvider
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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('user_has_credit', 'App\Http\Validators\UserHasCreditValidator@validate');
        Validator::extend('is_shopkeeper', 'App\Http\Validators\UserIsShopKeeperValidator@validate');
    }
}
