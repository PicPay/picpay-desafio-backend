<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\UserHistory;
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

$faker = \Faker\Factory::create('pt_BR');

$factory->define(User::class, function () use ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'document' => $faker->cpf(false) ,
        'type' => 'PERSON'
    ];
});


$factory->state(User::class, 'company', function () use ($faker) {
    return [
        'document' => $faker->cnpj(false) ,
        'type' => 'COMPANY'
    ];
});

$factory->define(UserHistory::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomFloat(2, -100.0, 100.0),
        'date' => date('Y-m-d H:i:s')
    ];
});