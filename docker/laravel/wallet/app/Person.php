<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DocumentType;
use App\User;

class Person extends Model
{
    protected $table = 'person';
    protected $fillable = [
        'id',
        'name',
        'document',
        'document_type_id',
        'person_type_id'
    ];

    protected $guarded = [
        'created_at',
        'update_at'
    ];

    public function personType()
    {
        return $this->belongsTo(PersonType::class, 'person_type', 'id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'person_id', 'id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'account_id', 'id');
    }
}
