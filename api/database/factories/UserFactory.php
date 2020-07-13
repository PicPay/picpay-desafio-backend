<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function () {
    $faker = new Faker\Generator();
    $faker->addProvider(new Faker\Provider\pt_BR\Person($faker));
    $faker->addProvider(new Faker\Provider\pt_BR\Company($faker));
    $faker->addProvider(new Faker\Provider\Internet($faker));

    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => Hash::make($faker->password),
        'isCompany' => false,
        'document' =>$faker->cpf(false),
        'balance' => 5000,
    ];
});

$factory->state(User::class, 'company', function () use ($factory) {
    $faker = new Faker\Generator();
    $faker->addProvider(new Faker\Provider\pt_BR\Company($faker));
    $user = $factory->raw(User::class);

    return array_merge($user, ['isCompany' => true, 'document' => $faker->cnpj(false)]);
});
