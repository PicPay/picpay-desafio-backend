<?php

/** @var Factory $factory */

use App\Models\Transaction;
use App\Models\Wallet;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Transaction::class, function (Faker $faker) {
    $payerWallet = factory(Wallet::class)->create();
    $payeeWallet = factory(Wallet::class)->create();
    $payerWallet->save();
    $payeeWallet->save();
    return [
        "value" => $faker->randomFloat(2, 35, 899),
        "payer_wallet_id" => $payerWallet->id,
        "payee_wallet_id" => $payeeWallet->id,
    ];
});
