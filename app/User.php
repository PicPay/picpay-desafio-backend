<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'type', 'document', 'wallet', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Users type | default
     *
     * @var int default
     */
    const default = 1;

    /**
     * Users type | seller
     *
     * @var int seller
     */
    const seller = 2;

    /**
     * Returns the user's contacts.
     */
    public function contacts()
    {
        return $this->hasMany('App\Contacts', 'user_id');
    }

    /**
     * Returns the user's received transactions.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transactions', 'receiver_id');
    }

    /**
     * Check if users type is default
     */
    public function default()
    {
        return $this->getAttribute('type') == self::default;
    }

    /**
     * Returns the user's balance, already formatted.
     */
    public function wallet()
    {
        return Common::decimal($this->getAttribute('wallet'));
    }

    /**
     * Returns the user's document, already formatted.
     */
    public function document()
    {
        return Common::formatDocument($this->getAttribute('document'));
    }

    /**
     * Returns the user's unread received transactions
     */
    public function unread()
    {
        return $transactions = $this->transactions()->where('read',(int)false)->count();
    }
}
