<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;

interface TransactionServiceInterface
{
    public function createTransaction(MoneyTransfer $moneyTransfer): Transaction;
}
