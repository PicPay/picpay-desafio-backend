<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'cpf_cnpj', 'user_type'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function sent()
    {
        return $this->hasMany(Transfer::class, 'payer_id', 'id');
    }

    public function received()
    {
        return $this->hasMany(Transfer::class, 'payee_id', 'id');
    }
}
