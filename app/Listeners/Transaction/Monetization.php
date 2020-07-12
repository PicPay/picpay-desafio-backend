<?php

namespace App\Listeners\Transaction;

use App\Events\Transaction\Validation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Interfaces\User\UserWalletInterface;
use App\Models\Transaction\Transaction;
use App\Interfaces\Transaction\TransactionInterface;
use Log;
use Exception;

class Monetization implements ShouldQueue
{
    private $userWalletRepository;

    private $transactionRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserWalletInterface $userWalletInterface, TransactionInterface $transaction)
    {
        $this->userWalletRepository = $userWalletInterface;
        $this->transactionRepository = $transaction;
    }

    /**
     * Handle the event.
     *
     * @param  Validation  $event
     * @return void
     */
    public function handle(Validation $event): bool
    {
        dump(__CLASS__);
        if ($this->hasntBeenAuthorized($event)) {
            return false;
        }

        $this->transferFunds($event);
        $this->updateTransactionStatus($event);

        return true;
    }

    /**
     * Queue validation
     *
     * @param Validation $event
     * @return bool
     */
    public function hasntBeenAuthorized(Validation $event): bool
    {
        return $this->transactionRepository->findById($event->transaction["id"])["status"] != Transaction::AUTHORIZED;
    }

    /**
     * Updating funds from users wallet
     *
     * @param array $transaction
     * @return void
     */
    private function transferFunds(Validation &$event): void
    {
        #request, verificar fundos e numeros nao negativos
        try {
            Log::info(__CLASS__);
            $payerWallet = $this->userWalletRepository->findByUserId($event->transaction["payer"]);
            $payeeWallet = $this->userWalletRepository->findByUserId($event->transaction["payee"]);

            $payerWallet["amount"] -= $event->transaction["value"];

            if ($payerWallet["amount"] < 0) {
                throw new Exception("Insuficient Funds!");
            }

            $payeeWallet["amount"] += $event->transaction["value"];

            $this->userWalletRepository->updateAmount($payerWallet["amount"], $payerWallet["id"]);
            $this->userWalletRepository->updateAmount($payeeWallet["amount"], $payeeWallet["id"]);

            $event->status = Transaction::APPROVED;
        } catch (Exception $exception) {
            Log::error($exception);
            $event->status = Transaction::INCONSISTENCY;
        }
    }

    private function updateTransactionStatus(Validation $event): void
    {
        $this->transactionRepository->updateStatus($event->status, $event->transaction["id"]);
    }
}
