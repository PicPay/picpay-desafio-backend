<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = 'document_type';
    protected $fillable = [
        'name',
        'description',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];
}
