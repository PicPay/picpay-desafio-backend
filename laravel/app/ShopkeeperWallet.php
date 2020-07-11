<?php

namespace App;

use App\Concepts\Wallet;
use App\Enums\WalletTypeEnum;
use App\Exceptions\InvalidOperationException;

class ShopkeeperWallet extends Wallet
{

    /**
     * @param float $value
     * @throws InvalidOperationException
     */
    public function subtract(float $value): void
    {
        throw new InvalidOperationException("Lojistas não podem transferir dinheiro.");
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where("type", WalletTypeEnum::SHOPKEEPER_WALLET);
        });
    }
}
