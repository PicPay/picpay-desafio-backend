<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallet';
    
    protected $primaryKey = 'id';
   
    protected $fillable = [
        'user_id',
        'wallet_type',
        'wallet',
        'created_at',
        'updated_at'
    ];
}





