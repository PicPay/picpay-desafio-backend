<?php

namespace App;

use App\Transaction;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Lumen\Auth\Authorizable;
use Exception;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    const TYPE_USER = 'user';
    const TYPE_STORE = 'store';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf_cnpj',
        'balance',
        'email',
        'type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'created_at', 'updated_at'
    ];

    public function transactions()
    {
        return $this->hasMany(\App\Transaction::class, 'payer_id');
    }

    /**
     * Make a transfer to another user
     *
     * @param Request $request
     */
    public function transfer(Request $request)
    {
        try {
            Transaction::create([
                'payer_id' => $request->get('payer'),
                'payee_id' => $request->get('payee'),
                'value' => $request->get('value'),
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
