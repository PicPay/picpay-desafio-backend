<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Model\Transactions\Transactions;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Transactions::class, function (Faker $faker) {
    return [
        'amount' => 100,
        'transaction_status_id' => 1,
        'authorized' => 0,
        'requested_date' => now(),
    ];
});
