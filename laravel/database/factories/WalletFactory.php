<?php

/** @var Factory $factory */

use App\Enums\WalletTypeEnum;
use App\Models\User;
use App\Models\Wallet;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Wallet::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $user->save();
    return [
        "balance" => $faker->randomFloat(2, 300, 800),
        "type" => $faker->randomElement(WalletTypeEnum::getConstants()),
        "user_id" => $user->id,
    ];
});
