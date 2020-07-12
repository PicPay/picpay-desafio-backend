<?php

namespace App\Models;

use App\Enums\UserIdentityTypeEnum;
use App\Enums\UserStatusEnum;
use App\Enums\WalletTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    protected $table = "users";

    protected $fillable = [
        "name",
        "email",
        "password",
    ];

    protected $attributes = [
        "identity_type" => UserIdentityTypeEnum::CPF,
        "status" => UserStatusEnum::ACTIVE,
    ];

    protected $hidden = ["password"];

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function userWallets(): HasMany
    {
        return $this->wallets->where("type", WalletTypeEnum::USER_WALLET);
    }

    public function shopkeeperWallets(): HasMany
    {
        return $this->wallets->where("type", WalletTypeEnum::SHOPKEEPER_WALLET);
    }
}
