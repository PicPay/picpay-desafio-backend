<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'user_contact_id'];

    public $timestamps = false;

    /**
     * Returns the user's contacts.
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_contact_id');
    }
}
