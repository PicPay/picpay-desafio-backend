<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TransferYourselfRule implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value === request()['payee_id']) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'It is not possible to transfer to yourself.';
    }
}
