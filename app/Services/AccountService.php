<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\AccountRepository;

class AccountService
{
    private $accountRepository;

    private $walletService;

    public function __construct(AccountRepository $accountRepository, WalletService $walletService)
    {
        $this->accountRepository = $accountRepository;

        $this->walletService = $walletService;
    }

    public function create(array $attributes): User
    {
        $attributes['password'] = Hash::make($attributes['password']);

        $wallet = $this->walletService->create([]);

        return $this->accountRepository->createWithAssociations($attributes, ['wallet' => $wallet]);
    }

    public function getUserById(int $id): User
    {
        return $this->accountRepository->getById($id);
    }
}
