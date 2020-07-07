<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer\Account\Balance;

use App\Domain\Shared\ValueObject\Amount;
use App\Domain\Shared\ValueObject\AmountInterface;
use App\Domain\Shared\ValueObject\TransactionAmountInterface;

final class Subtract implements OperationInterface
{
    public function getBalance(
        TransactionAmountInterface $transactionAmount,
        AmountInterface $balance
    ): AmountInterface {
        return new Amount(
            $balance->getValue() - $transactionAmount->getValue()
        );
    }
}
