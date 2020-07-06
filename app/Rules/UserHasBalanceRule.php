<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserHasBalanceRule implements Rule
{
    protected $messageAux;

    public function passes($attribute, $value)
    {
        $this->messageAux = 'The balance is less than '. $value . '.';

        $payerId = request()['payer_id'];
        $user = User::find($payerId);
        if ( ! $user) {
            return false;
        }
        $wallet = $user->wallet()->first();
        if ($wallet->balance < $value) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return $this->messageAux;
    }
}
