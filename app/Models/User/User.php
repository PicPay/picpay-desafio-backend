<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\UsersWallet;

class User extends Model 
{
    protected $table = 'users';

    public function wallet(): UsersWallet
    {
        return $this->hasOne(UsersWallet);
    }
}
