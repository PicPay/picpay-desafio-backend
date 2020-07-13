<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileFormRequest extends FormRequest
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
        $id = auth()->user()->id;

        return [
            'name'     => 'required|string|max:255',
            'cpf_cnpj' => "required|formato_cpf_cnpj|cpf_cnpj|unique:users,cpf_cnpj,{$id},id",
            'email'    => "required|string|email|max:255|unique:users,email,{$id},id",
            'password' => 'nullable|min:8|confirmed',
            // 'image'     => 'image'
        ];
    }
}
