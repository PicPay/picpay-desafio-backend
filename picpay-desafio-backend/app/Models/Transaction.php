<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['payer_id', 'payee_id', 'value'];

    public function wallet()
    {
        return $this->belongsTo('App\Models\Wallet');
    }
}
