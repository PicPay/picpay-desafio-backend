<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PersonType;
use Faker\Generator as Faker;

$factory->define(PersonType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'description' => $faker->text
    ];
});
