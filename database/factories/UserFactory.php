<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User\User;
use App\Models\User\UsersWallet;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'email' => $faker->email,
        'password' => $faker->password(8),
        'type' => $faker->randomElement(["Common", "Shopkeeper"])
    ];
});

$factory->afterCreating(User::class, function ($user) {
    factory(UsersWallet::class)->create(["user_id" => $user->id]);
});