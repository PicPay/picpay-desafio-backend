<?php

namespace App\Traits;

use Illuminate\Validation\Rule;

trait UserTrait
{
    public function getFillables()
    {
        return ['name', 'email', 'cpf_cnpj', 'user_type', 'password'];
    }

    public function getRules($id = null)
    {
        $validate = [
            'name' => ['required'],
            'email' => ['required', 'unique:users'],
            'cpf_cnpj' => ['required', 'unique:users'],
            'user_type' => ['required'],
            'password' => ['required'],
        ];
        if ($id) {
            $validate = [
                'name' => ['required'],
                'email' => ['required', Rule::unique('users')->ignore($id)],
                'cpf_cnpj' => ['required', Rule::unique('users')->ignore($id)],
                'user_type' => ['required'],
                'password' => ['required'],
            ];
        }

        return $validate;
    }

    public function getMessages()
    {
        return [];
    }

    public function getAttributes()
    {
        return [
            'name' => __('fields.name'),
            'email' => __('fields.email'),
            'cpf_cnpj' => __('fields.cpf_cnpj'),
            'user_type' => __('fields.user_type'),
            'password' => __('fields.password')
        ];
    }

    public function getMessageSuccess($update = false)
    {
        $message = __('messages.userCreateSuccess');
        if ($update) {
            $message = __('messages.userUpdateSuccess');
        }
        return $message;
    }
}
