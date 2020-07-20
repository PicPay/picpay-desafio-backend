<?php

namespace App\Models;

use App\Http\Requests\UserRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Throwable;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function transaction()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function hasBalance(float $value)
    {
        return $this->balance >= $value;
    }

    public final function createWallet(User $user, UserRequest $request)
    {
        try {
            DB::transaction(function () use ($user, $request) {
                $wallet = new Wallet();
                $wallet->user_id = $user->id;
                $wallet->balance = 0.0;
                $wallet->saveOrFail();
            });
        }catch (Throwable $error){
            return $error->getMessage();
        }
    }

    public function addBalance(float $value)
    {
        $this->balance += $value;
    }

    public function debitBalance(float $value)
    {
        $this->balance -= $value;
    }
}
