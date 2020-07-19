<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\AccountRepository;

class AccountService
{
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function create(array $attributes): User
    {
        $attributes['password'] = Hash::make($attributes['password']);

        return $this->accountRepository->create($attributes);
    }
}
