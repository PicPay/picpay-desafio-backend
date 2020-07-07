<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Repository\TransactionRepositoryInterface;

final class TransactionService implements TransactionServiceInterface
{
    use TransactionRepositoryHelperTrait;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->setTransactionRepository($transactionRepository);
    }

    public function createTransaction(MoneyTransfer $moneyTransfer): Transaction
    {
        return $this
            ->getTransactionRepository()
            ->create($moneyTransfer)
        ;
    }
}
