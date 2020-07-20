<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email', 'type', 'document', 'password'];

    protected $hidden = ['password'];

    public function wallet()
    {
        return $this->hasOne('App\Models\Wallet');
    }

    public function isSalesPerson()
    {
        return $this->type == UserType::SalesPerson ? true : false;
    }


}
