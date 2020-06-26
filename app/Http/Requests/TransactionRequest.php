<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionRequest extends Request
{
    public function all( $keys = NULL ): array
    {
        return $this->json()->all( $keys );
    }
    
    public function rules()
    {
        return [
            'value' => 'required|numeric',
            'payer' => [ 'required', Rule::exists('user', 'id')->where( 'is_merchant', 0 )],
            'payee' => 'required|exists:user,id',
        ];
    }

    public function messages()
    {
        return [
            'value.required'  => 'Must provide a value',
            'value.numeric'   => 'Must provide a valid value',
            'payer.required'  => 'Must provide a valid payer (not be merchant)',
            'payer.exists'    => 'Payer must be valid',
            'payee.required'  => 'Must provide a payee',
            'payee.exists'    => 'Payee must be valid',
        ];
    }
}
