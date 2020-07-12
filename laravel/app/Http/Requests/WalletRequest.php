<?php

namespace App\Http\Requests;

use App\Enums\WalletTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "balance" => "numeric|min:0.00",
            "type" => "string|in:" . implode(",", WalletTypeEnum::getConstants()),
        ];
    }

    public function messages(): array
    {
        return [
            "balance.required" => "O campo saldo é obrigatório.",
            "balance.numeric" => "O campo saldo precisa ser um número.",
            "balance.min" => "O campo saldo precisa ser maior do que zero.",
            "type.required" => "O campo tipo é obrigatório.",
            "type.in" => "Tipo inválido.",
        ];
    }
}
