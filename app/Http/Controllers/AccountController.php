<?php

namespace App\Http\Controllers;

use App\Enum\UserType;
use Illuminate\Http\Request;
use App\Services\AccountService;

class AccountController extends Controller
{
    private $accountService;

    private function validateMessage(): array
    {
        return [
            'document.cpf_cnpj' => 'The document informed is not valid',
        ];
    }

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function create(Request $request)
    {
        $userType = implode(',', [UserType::CUSTUMER, UserType::SELLER]);

        $payload = $this->validate($request, [
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'document' => [
                'required',
                'max:14',
                'unique:users',
                'cpf_cnpj',
            ],
            'type' => ['required', "in:$userType"],
        ], $this->validateMessage());

        $this->tryCacthTransaction(function () use ($payload) {
            $this->accountService->create($payload);
        });

        return response(null, 201);
    }
}
