<?php

namespace App\Http\Requests;

class CreateUserRequest extends UserRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            "password" => "required|string|min:6|max:30",
            "confirmPassword" => "same:password",
        ]);
    }
}
