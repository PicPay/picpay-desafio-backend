<?php

namespace App\Models;

use App\Concepts\Person;
use App\Enums\PersonIdentityTypeEnum;
use App\Enums\PersonStatusEnum;
use App\Enums\PersonTypeEnum;

class User extends Person
{

    protected $attributes = [
        "identity_type" => PersonIdentityTypeEnum::CPF,
        "status" => PersonStatusEnum::ACTIVE,
        "type" => PersonTypeEnum::USER,
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where("type", PersonTypeEnum::USER);
        });
    }
}
