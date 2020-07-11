<?php

namespace App;

use App\Concepts\Person;
use App\Enums\PersonIdentityTypeEnum;
use App\Enums\PersonStatusEnum;
use App\Enums\PersonTypeEnum;

class Shopkeeper extends Person
{
    protected $attributes = [
        "identity_type" => PersonIdentityTypeEnum::CPF,
        "status" => PersonStatusEnum::ACTIVE,
        "type" => PersonTypeEnum::SHOPKEEPER,
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where("type", PersonTypeEnum::SHOPKEEPER);
        });
    }
}
