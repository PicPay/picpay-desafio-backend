<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class Transaction extends Model 
{
    CONST PENDING = "pending";
    CONST APPROVED = "approved";
    CONST AUTHORIZED = "authorized";
    CONST INCONSISTENCY = "inconsistency";

    protected $table = 'transactions';

    protected $fillable = ["payer", "payee", "value", "status"];

    protected $attributes = [
        'status' => self::PENDING
    ];

    public function payer()
    {
        return $this->belongsTo('App\Models\User', "users_payer_id_foreign", "payer");
    }

    public function payee()
    {
        return $this->belongsTo('App\Models\User', "users_payer_id_foreign", "payee");
    }
}
