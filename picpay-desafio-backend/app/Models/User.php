<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email', 'type', 'document', 'password'];
    protected $appends  = ['id'];

    protected $hidden = ['password'];

    public function wallet()
    {
        return $this->hasOne('App\Models\Wallet');
    }

}
