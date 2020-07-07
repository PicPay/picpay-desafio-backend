<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';
    protected $fillable = [
        'code',
        'balance',
        'person_id'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }
}
