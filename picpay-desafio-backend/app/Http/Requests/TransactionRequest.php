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
            'payer_id' => [
                'required',
                Rule::exists('users', 'id')
            ],
            'payee_id' => [
                'required',
                Rule::exists('users', 'id')
            ]
        ];
    }

    public function messages()
    {
        return [
            'payer_id.required' => 'ID do pagador é obrigatório',
            'payee_id.required' => 'ID do receptor é obrigatório',
            'payer_id.exists'   => 'ID do pagador não encontrado',
            'payee_id.exists'   => 'ID do receptor não encontrado',
        ];
    }
}
