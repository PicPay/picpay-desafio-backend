<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Wallet;
use Faker\Generator as Faker;


/*
|--------------------------------------------------------------------------
| Wallet Model Factories
|--------------------------------------------------------------------------
*/

$factory->define(Wallet::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    return [
        'balance' => $faker->randomFloat(2, 10, 500),
        'user_id' => $user->id,
    ];
});

