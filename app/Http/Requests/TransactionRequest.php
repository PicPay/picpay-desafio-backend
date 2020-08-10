<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payer' => 'bail|required|integer|exists:users,user_id|is_shopkeeper|user_has_credit',
            'payee' => 'bail|required|integer|exists:users,user_id|different:payer',
            'value' => 'bail|required|numeric|min:1',
        ];
    }
}
