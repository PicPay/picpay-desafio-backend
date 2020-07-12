<?php

namespace App\Http\Requests;

use App\Enums\UserStatusEnum;

class UpdateUserRequest extends UserRequest
{
    public function rules(): array
    {
        $rules = array_merge(parent::rules(), [
            'password' => ['min:6|max:30'],
            'confirmPassword' => 'same:password',
            "status" => "string|in:" . implode(",", UserStatusEnum::getConstants()),
        ]);
        unset($rules["wallet_type"]);
        return $rules;
    }
}
