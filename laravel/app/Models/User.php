<?php

namespace App\Models;

use App\Enums\UserIdentityTypeEnum;
use App\Enums\UserStatusEnum;
use Illuminate\Database\Eloquent\Model;
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

    public function hasCpf(): bool
    {
        return $this->identity_type === UserIdentityTypeEnum::CPF;
    }

    public function hasCnpj(): bool
    {
        return $this->identity_type === UserIdentityTypeEnum::CNPJ;
    }

    public function isActive(): bool
    {
        return $this->status === UserStatusEnum::ACTIVE;
    }

    public function isBanned(): bool
    {
        return $this->status === UserStatusEnum::BANNED;
    }
}
