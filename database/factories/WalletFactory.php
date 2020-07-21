<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(),
        'amount' => $faker->randomFloat(2, 1, 999999),
    ];
});
