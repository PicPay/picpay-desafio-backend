<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserExistRule implements Rule
{
    public function passes($attribute, $value)
    {
        $user = User::find($value);
        if ( ! $user) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'The :attribute does not exist.';
    }
}
