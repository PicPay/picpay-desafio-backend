<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'document', 'type'
    ];

    public function history()
    {
        return $this->hasMany(UserHistory::class);
    }

}