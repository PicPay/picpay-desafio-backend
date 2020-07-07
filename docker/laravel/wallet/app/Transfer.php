<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfer';
    protected $fillable = [
        'id',
        'payer',
        'payee',
        'value',
    ];

    protected $guarded = [
        'created_at',
        'update_at'
    ];

    public function payer()
    {
        return $this->belongsTo(PersonType::class, 'payer', 'id');
    }

    public function payee()
    {
        return $this->belongsTo(PersonType::class, 'payee', 'id');
    }
}
