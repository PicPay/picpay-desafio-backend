<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payer_wallet_id' => [
                'required',
                Rule::exists('wallets', 'id')
            ],
            'payee_wallet_id' => [
                'required',
                Rule::exists('wallets', 'id')
            ]
        ];
    }

    public function messages()
    {
        return [
            'payer_wallet_id.required' => 'ID do pagador é obrigatório',
            'payee_wallet_id.required' => 'ID do receptor é obrigatório',
            'payer_wallet_id.exists'   => 'ID do pagador não encontrado',
            'payee_wallet_id.exists'   => 'ID do receptor não encontrado',
        ];
    }
}
