<?php

/** @var Factory $factory */

use App\Enums\PersonIdentityTypeEnum;
use App\Enums\PersonStatusEnum;
use App\Enums\PersonTypeEnum;
use App\Models\Shopkeeper;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Person as FakerPersonProvider;
use Faker\Provider\pt_BR\Company as FakerCompanyProvider;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Shopkeeper::class, function (Faker $faker) {
    $faker->addProvider(new FakerPersonProvider($faker));
    $faker->addProvider(new FakerCompanyProvider($faker));
    return [
        "name" => $faker->company,
        "email" => $faker->companyEmail,
        "password" => $faker->password,
        "identity" => $faker->cnpj,
        "identity_type" => PersonIdentityTypeEnum::CNPJ,
        "status" => PersonStatusEnum::ACTIVE,
        "type" => PersonTypeEnum::SHOPKEEPER,
    ];
});
