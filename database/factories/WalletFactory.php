<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Wallet;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return App\Models\User::where('user_type', 'common')->first()->id;
        },
        'balance' => $faker->randomFloat('2', 10, 200)
    ];
});
