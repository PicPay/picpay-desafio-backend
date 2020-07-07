<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer\Account\Balance;

use App\Domain\Shared\ValueObject\AmountInterface;
use App\Domain\Shared\ValueObject\TransactionAmountInterface;

interface OperationInterface
{
    public function getBalance(
        TransactionAmountInterface $transactionAmount,
        AmountInterface $balance
    ): AmountInterface;
}
