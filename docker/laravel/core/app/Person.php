<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'person';
    protected $fillable = [
        'name',
        'document',
        'document_type',
        'person_type'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];
}
