<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;

interface AccountTransactionOperationServiceInterface
{
    public function createTransactionOperation(MoneyTransfer $moneyTransfer, Transaction $transaction): void;

    public function createTransactionRefundOperation(MoneyTransfer $moneyTransfer, Transaction $transaction): void;
}
