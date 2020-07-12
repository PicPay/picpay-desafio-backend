<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_type_id',
        'document',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function userType()
    {
        return $this->belongsTo(\App\UserType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payer()
    {
        return $this->hasMany(\App\Transaction::class, 'payer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payee()
    {
        return $this->hasMany(\App\Transaction::class, 'payee_id');
    }

    /**
     * Calculates the balance.
     *
     * @return int
     */
    public function balance()
    {
        try {
            $user = auth()->user();

            $payer = $user->payer()->sum('value');
            $payee = $user->payee()->sum('value');

            return $payee - $payer;
        } catch (\Exception $e) {
            logger()->error((string)$e);
            return 0;
        }
    }

    /**
     * Valid if you can pay
     *
     * @return bool
     */
    public function canPay($transaction_value = null)
    {
        try {
            if (auth()->user()->user_type_id != UserType::COMMON) {
                return false;
            }

            $balance = $this->balance();

            $validade = $balance <= 0;

            if ($transaction_value) {
                $balance -= $transaction_value;

                $validade = $balance < 0;
            }

            if ($validade) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            logger()->error((string)$e);
            return false;
        }
    }
}
