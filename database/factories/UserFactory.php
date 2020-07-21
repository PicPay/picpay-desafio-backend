<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Enum\UserType;
use App\Models\Wallet;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\Company;
use Illuminate\Hashing\BcryptHasher;

$factory->define(User::class, function (Faker $faker) {
    $faker->addProvider(new Person($faker));
    $faker->addProvider(new Company($faker));

    $type = $faker->randomElement([UserType::SELLER, UserType::CUSTUMER]);

    $document = $faker->cpf(false);

    if ($type === UserType::SELLER) {
        $document = $faker->cnpj(false);
    }

    return [
        'id' => $faker->randomNumber(),
        'fullName' => $faker->name,
        'email' => $faker->email,
        'type' => $type,
        'document' => $document,
        'email' => $faker->email,
        'password' => (new BcryptHasher)->make($faker->email),
        'wallet_id' => $faker->randomNumber()
    ];
});
