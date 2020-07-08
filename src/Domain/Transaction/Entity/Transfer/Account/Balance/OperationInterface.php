<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer\Account\Balance;

use App\Domain\Shared\ValueObject\Amount\BalanceAmountInterface;
use App\Domain\Shared\ValueObject\Amount\TransactionAmountInterface;

interface OperationInterface
{
    public function getBalance(
        TransactionAmountInterface $transactionAmount,
        BalanceAmountInterface $balance
    ): BalanceAmountInterface;
}
