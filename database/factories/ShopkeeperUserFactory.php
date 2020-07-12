<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User\ShopkeeperUser;
use App\Models\User\User;
use Faker\Generator as Faker;

$factory->define(ShopkeeperUser::class, function (Faker $faker) {
    return [
        'cnpj' => $faker->numerify("###########"),
        'user_id' => factory(User::class)->create(['type' => 'Shopkeeper']),
    ];
});
