<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name'     => 'required|min:3',
            'email'    => [
                'required',
                Rule::unique('users', 'email')->ignore($this->user)],
            'type'     => [
                'required',
                Rule::in(UserType::Regular, UserType::SalesPerson)
                ],
            'document' => [
                'required',
                Rule::unique('users', 'document')->ignore($this->user)
            ],
            'password' => 'required|min:8|max:14',
        ];
        if ($this->type == UserType::SalesPerson){
            $rules['document'][] = 'cnpj';
        } else {
            $rules['document'][] = 'cpf';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'     => 'Nome é obrigatório',
            'email.required'    => 'Email é obrigatório',
            'type.required'     => 'Tipo de usuário é obrigatório',
            'document.required' => 'Documento é obrigatório',
            'password.required' => 'Senha é obrigatória',
            'email.unique'      => 'Já existe um usuário com este email',
            'document.unique'   => 'Já existe um usuário com este documento',
            'name.min'          => 'Informe o nome completo',
            'email.email'       => 'Informe um email válido',
            'type.in'           => 'Tipo de usuário deve ser Comum ou Logista',
            'document.in'       => 'Documento inválido',
            'password.min'      => 'A senha deve ter no mínimo 8 e no máximo 14 caracteres',
            'password.max'      => 'A senha deve ter no mínimo 8 e no máximo 14 caracteres',
        ];
    }
}
