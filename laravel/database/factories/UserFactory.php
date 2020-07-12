<?php

/** @var Factory $factory */

use App\Enums\PersonIdentityTypeEnum;
use App\Enums\PersonStatusEnum;
use App\Enums\PersonTypeEnum;
use App\Models\User;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Person as FakerPersonProvider;
use Illuminate\Database\Eloquent\Factory;

$factory->define(User::class, function (Faker $faker) {
    $faker->addProvider(new FakerPersonProvider($faker));
    return [
        "name" => $faker->name,
        "email" => $faker->safeEmail,
        "password" => $faker->password,
        "identity" => $faker->cpf,
        "identity_type" => PersonIdentityTypeEnum::CPF,
        "status" => PersonStatusEnum::ACTIVE,
        "type" => PersonTypeEnum::USER,
    ];
});
