<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User\CommonUser;
use App\Models\User\User;
use Faker\Generator as Faker;

$factory->define(CommonUser::class, function (Faker $faker) {
    return [
        'cpf' => $faker->numerify("###########"),
        'user_id' => factory(User::class)->create(['type' => 'Common']),
    ];
});
