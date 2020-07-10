<?php

namespace App\Services\Wallet;

use App\Repositories\Contracts\Users\UsersRepositoryContract;
use App\Services\Contracts\Wallet\WalletServiceContract;

class WalletService implements WalletServiceContract
{

    /**
     * @var UsersRepositoryContract
     */
    private $userRepository;

    public function __construct(UsersRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function applyTransfer($payer_id, $payee_id, $value): void
    {
        $payer = $this->userRepository->findUser($payer_id);
        $payee = $this->userRepository->findUser($payee_id);
        $this->userRepository->updateUser($payer_id, ['wallet_amount' => $payer->wallet_amount -= $value]);
        $this->userRepository->updateUser($payee_id, ['wallet_amount' => $payee->wallet_amount += $value]);
    }

    public function revertTransfer($payer_id, $payee_id, $value): void
    {
        $payer = $this->userRepository->findUser($payer_id);
        $payee = $this->userRepository->findUser($payee_id);
        $this->userRepository->updateUser($payer_id, ['wallet_amount' => $payer->wallet_amount += $value]);
        $this->userRepository->updateUser($payee_id, ['wallet_amount' => $payee->wallet_amount -= $value]);
    }

    public function isReversible($transfer)
    {
        $payee = $this->userRepository->findUser($transfer->payee_id);
        $remaining_amount = $payee->wallet_amount - $transfer->value;
        return $remaining_amount >= 0 && $transfer->authorization_status === 1 && $transfer->processed === 1 && $transfer->cancelled === 1;
    }
}
