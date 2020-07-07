<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;

final class TransactionService extends AbstractService
{
    public function createTransaction(MoneyTransfer $moneyTransfer): Transaction
    {
        // @todo throw here
        return $this
            ->getTransactionRepository()
            ->create($moneyTransfer)
        ;
    }
}
