<?php

namespace App;

use App\Concepts\Wallet;
use App\Enums\WalletTypeEnum;

class UserWallet extends Wallet
{

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where("type", WalletTypeEnum::USER_WALLET);
        });
    }
}
