<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'document' => 'required|unique:users,document,'.$this->segment(4).',id',
            'email' => 'required|email|unique:users,email,'.$this->segment(4).',id',
            'password' => 'required|min:4'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo Email é obrigatório',
            'document.required' => 'O campo Email é obrigatório',
            'document.unique' => 'Já existe um cadastrado com esse Documento',
            'email.required' => 'O campo Email é obrigatório',
            'email.email' => 'Formato inválido para o campo Email',
            'email.unique' => 'Já existe um cadastrado com esse Email',
            'password.required' => 'O campo Senha é obrigatório',
            'password.min'  => 'O campo Senha deve ter no mínimo 4 carateres',
        ];
    }
}
