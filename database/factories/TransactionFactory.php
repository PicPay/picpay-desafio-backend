<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enum\TransactionStatus;
use App\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    $status = $faker->randomElement([TransactionStatus::PROCESSED, TransactionStatus::UNAUTHORIZED, TransactionStatus::UNPROCESSED]);

    return [
        'id' => $faker->randomNumber(),
        'value' => $faker->randomFloat(2, 1, 10000),
        'status' => $status,
    ];
});
