<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Repository\TransactionRepositoryInterface;

trait TransactionRepositoryHelperTrait
{
    private TransactionRepositoryInterface $transactionRepository;

    protected function getTransactionRepository(): TransactionRepositoryInterface
    {
        return $this->transactionRepository;
    }

    protected function setTransactionRepository(TransactionRepositoryInterface $transactionRepository): void
    {
        $this->transactionRepository = $transactionRepository;
    }
}
