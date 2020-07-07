<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Person;

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

    public function persons()
    {
        return $this->hasMany(Person::class, 'document_type_id', 'id');
    }
}
