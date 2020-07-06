<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'payer_id', 'payee_id', 'value'
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id', 'id');
    }

    public function payee()
    {
        return $this->belongsTo(User::class, 'payee_id', 'id');
    }
}
