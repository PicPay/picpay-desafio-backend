<?php

use App\Models\User;
use App\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    $userData = factory(User::class)->create();
    return [
        'user_id' => $userData->id,
        'balance' => $faker->randomFloat(2, 0, 99999),
        'wallet_type' => $faker->numberBetween(1,2)
    ];
});