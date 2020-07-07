<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService;

use App\Domain\Shared\ValueObject\AmountInterface;
use App\Domain\Shared\ValueObject\TransactionAmountInterface;
use RuntimeException;

use function sprintf;

class InsufficientBalanceException extends RuntimeException
{
    public static function handle(
        AmountInterface $payerAccountBalance,
        TransactionAmountInterface $moneyTransferAmount
    ): self {
        return new self(
            sprintf(
                'Insufficient balance in payer account to do money transfer, '
                    . 'balance [ %d ], required to transfer [ %d ]',
                $payerAccountBalance->getValue(),
                $moneyTransferAmount->getValue()
            )
        );
    }
}
