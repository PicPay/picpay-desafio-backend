<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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

$faker = \Faker\Factory::create('pt_BR');

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'document' => $faker->cnpj,
        'email' => $faker->unique()->freeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make(Str::random(10)),
        'remember_token' => Str::random(10),
        'type' => $faker->randomElement(['NORMAL', 'SHOPKEEPER']),
        'balance' => $faker->randomFloat(5, 0, 20),
    ];
});
