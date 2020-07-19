<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\UserType;
use App\Models\User;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Person as FakerPersonProvider;


/*
|--------------------------------------------------------------------------
| User Model Factories
|--------------------------------------------------------------------------
*/

$factory->define(User::class, function (Faker $faker) {
    $faker->addProvider(new FakerPersonProvider($faker));
    return [
        'name'     => $faker->name,
        'email'    => $faker->unique()->safeEmail,
        'document' => $faker->unique()->cpf,
        'password' => $faker->password(),
        'type'     => $faker->randomElement($array = array (UserType::Regular,UserType::SalesPerson)),
    ];
});

