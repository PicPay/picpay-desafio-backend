<?php

namespace App\Models;

use App\Enums\WalletTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $table = "wallets";
    protected $attributes = [
        "balance" => 0.0,
        "type" => WalletTypeEnum::USER_WALLET,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function purchaseTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payer_wallet_id');
    }

    /**
     * @return HasMany
     */
    public function saleTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payee_wallet_id');
    }

    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->purchaseTransactions->merge($this->saleTransactions);
    }
}
