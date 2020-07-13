<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User\UsersWallet;
use App\Models\User\User;
use Faker\Generator as Faker;

$factory->define(UsersWallet::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomFloat(2, 100, 1000),
        'user_id' => $faker->randomDigit(),
    ];
});
