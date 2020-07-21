<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\ControllerMiddlewareOptions;
use Illuminate\Support\Facades\Auth;

class Transactions extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sender_id', 'receiver_id', 'value', 'authorized', 'read'];

    /**
     * Makes the authorized transaction condition default.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('authorized', function (Builder $builder) {
            $builder->where('authorized', (int)true);
        });
    }

    /**
     * Returns the user who submitted the transaction.
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    /**
     * Returns the user who received the transaction.
     */
    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }

    /**
     * Checks if the user received the transaction.
     */
    public function received()
    {
        return $this->getAttribute('receiver_id') == Auth::user()->getAuthIdentifier();
    }

    /**
     * Returns the transaction value formatted.
     */
    public function value()
    {
        return Common::decimal($this->getAttribute('value'));
    }

    /**
     * Returns the transaction date formatted.
     */
    public function date()
    {
        return Carbon::parse($this->getAttribute('created_at'))->format('d/m/Y H:i');
    }

}
