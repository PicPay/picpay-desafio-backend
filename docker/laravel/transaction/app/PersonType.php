<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Person;

class PersonType extends Model
{
    protected $table = 'person_type';
    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    protected $guarded = [
        'created_at',
        'update_at'
    ];

    public function persons()
    {
        return $this->hasMany(Person::class, 'person_type_id', 'id');
    }
}
