<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    
    protected $primaryKey = 'id';
   
    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
        'status',
        'created_at',
        'updated_at'
    ];
}
