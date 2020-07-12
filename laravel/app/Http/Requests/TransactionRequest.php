<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "value" => "required|numeric|min:0.01",
            "payer" => "required|exists:users,id",
            "payee" => "required|exists:users,id",
        ];
    }

    public function messages(): array
    {
        return [
            "value.required" => "O campo valor é obrigatório.",
            "email.required" => "O campo e-mail é obrigatório.",
            "email.unique" => "O e-mail já está em uso.",
            "identity_type.required" => "O tipo de identidade é obrigatório.",
            "identity.required" => "O campo documento é obrigatório.",
            "identity.cpf" => "O documento precisa ser um CPF válido.",
            "identity.cnpj" => "O documento precisa ser um CNPJ válido.",
            "status.required" => "O campo status é obrigatório.",
            "status.in" => "Status inválido.",
        ];
    }
}
