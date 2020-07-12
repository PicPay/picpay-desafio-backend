<?php

namespace App\Models;

use App\Enums\UserIdentityTypeEnum;
use App\Enums\UserStatusEnum;
use App\Enums\WalletTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    protected $table = "users";

    protected $fillable = [
        "name",
        "email",
        "password",
        "identity_type",
        "identity",
    ];

    protected $attributes = [
        "identity_type" => UserIdentityTypeEnum::CPF,
        "status" => UserStatusEnum::ACTIVE,
    ];

    protected $hidden = ["password"];

    /**
     * @return HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }
}
