<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DocumentType;
use App\User;

class Transfer extends Model
{
    protected $table = 'transfer';
    protected $fillable = [
        'payer',
        'payee',
        'value'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];

    public function payer()
    {
        return $this->belongsTo(Person::class, 'payer', 'id');
    }

    public function payee()
    {
        return $this->belongsTo(Person::class, '´payee', 'id');
    }
}
