<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false; 

    protected $fillable = [
        'payer', 'payee', 'value', 'status'
    ];
}