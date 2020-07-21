<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Repositories\WalletRepository;

class WalletService
{
    private $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function create($attributes): Wallet
    {
        return $this->walletRepository->create($attributes);
    }

    public function updateByTransaction(Transaction $transaction): Wallet
    {
        $wallet = $transaction->wallet;

        return $this->walletRepository->update($wallet, ['amount' => bcadd($wallet->amount, $transaction->value)]);
    }
}
