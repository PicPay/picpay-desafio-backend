<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function transaction()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}
