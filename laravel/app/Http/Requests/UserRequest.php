<?php

namespace App\Http\Requests;

use App\Enums\UserIdentityTypeEnum;
use App\Enums\WalletTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            "name" => "required|string",
            "email" => [
                "required",
                "email",
                Rule::unique('users', 'email')
                    ->ignore($this->user),
            ],
            "identity_type" => "required|string|in:" . implode(",", UserIdentityTypeEnum::getConstants()),
            "wallet_type" => "required|string|in:" . implode(",", WalletTypeEnum::getConstants()),
            "password" => "required|string|min:6|max:30",
            "identity" => ["required"],
        ];
        switch ($this->identity_type) {
            case UserIdentityTypeEnum::CPF:
                $rules["identity"][] = "cpf";
                break;
            case UserIdentityTypeEnum::CNPJ:
                $rules["identity"][] = "cnpj";
                break;
        }
        $rules["identity"][] = Rule::unique('users', 'identity')->ignore($this->user);
        return $rules;
    }

    public function messages(): array
    {
        return [
            "name.required" => "O campo nome é obrigatório.",
            "email.required" => "O campo e-mail é obrigatório.",
            "email.email" => "E-mail inválido.",
            "email.unique" => "O e-mail já está em uso.",
            "identity_type.required" => "O tipo de identidade é obrigatório.",
            "identity_type.in" => "Tipo de identidade inválido.",
            "wallet_type.required" => "O tipo de carteira é obrigatório.",
            "wallet_type.in" => "Tpo de carteira inválido.",
            "identity.required" => "O campo documento é obrigatório.",
            "identity.cpf" => "O documento precisa ser um CPF válido.",
            "identity.cnpj" => "O documento precisa ser um CNPJ válido.",
            "identity.unique" => "O documento já está em uso.",
            "status.required" => "O campo status é obrigatório.",
            "status.in" => "Status inválido.",
            "password.required" => "O campo senha é obrigatório",
            "password.min" => "A senha precisa ter pelo menos 6 caracteres",
            "password.max" => "A senha não pode ter mais de 30 caracteres",
            "confirmPassword.same" => "As senhas estão diferentes.",
        ];
    }
}
