<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Repositories\WalletRepository;

class WalletService
{
    private $walletRepository;

    private $authService;

    public function __construct(WalletRepository $walletRepository, AuthService $authService)
    {
        $this->walletRepository = $walletRepository;

        $this->authService = $authService;
    }

    public function create(array $attributes): Wallet
    {
        return $this->walletRepository->create($attributes);
    }

    public function withdrawByTransaction(Transaction $transaction): Wallet
    {
        $wallet = $transaction->payer->wallet;

        return $this->walletRepository->update($wallet, ['amount' => bcsub($wallet->amount, $transaction->value)]);
    }

    public function depositByTransaction(Transaction $transaction): Wallet
    {
        $wallet = $transaction->payee->wallet;

        return $this->walletRepository->update($wallet, ['amount' => bcadd($wallet->amount, $transaction->value)]);
    }

    public function rollbackByTransaction(Transaction $transaction): void
    {
        $payerWallet = $transaction->payer->wallet;

        $this->walletRepository->update($payerWallet, ['amount' => bcadd($payerWallet->amount, $transaction->value)]);

        $payeeWallet = $transaction->payee->wallet->refresh();

        $this->walletRepository->update($payeeWallet, ['amount' => bcsub($payeeWallet->amount, $transaction->value)]);
    }

    public function directWithdraw(float $value): Wallet
    {
        $user = $this->authService->context();

        $value = bcadd($user->wallet->amount, $value);

        return $this->walletRepository->update($user->wallet, ['amount' => $value]);
    }
}
