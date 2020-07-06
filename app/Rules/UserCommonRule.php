<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserCommonRule implements Rule
{
    protected $messageAux;

    public function passes($attribute, $value)
    {
        $this->messageAux = 'The :attribute must be an ordinary user.';
        $user = User::find($value);
        if ( ! $user ) {
            $this->messageAux = 'The Payer does not exist.';
            return false;
        }
        if ($user->user_type !== 'common') {
            return false;
        }
        return true;
    }

    public function message()
    {
        return $this->messageAux;
    }
}
