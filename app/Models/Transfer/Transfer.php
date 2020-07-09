<?php

namespace App\Models\Transfer;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfer';
    protected $fillable = ['payer_id', 'payee_id', 'value'];
}
