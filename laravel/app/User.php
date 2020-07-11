<?php

namespace App;

use App\Concepts\Person;
use App\Enums\PersonTypeEnum;

class User extends Person
{
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where("type", PersonTypeEnum::USER);
        });
    }
}
