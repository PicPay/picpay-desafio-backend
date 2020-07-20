<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    public $timestamps = false;

    public $table =  'user_history';

    protected $fillable = [
        'user_id', 'amount', 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}