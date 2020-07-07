<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Exception\Service\MoneyTransfer\TransferService;

use App\Domain\Transaction\Entity\Transfer\AbstractAccount;
use RuntimeException;

use function sprintf;

class AccountNotFoundException extends RuntimeException
{
    public static function handle(string $accountType, AbstractAccount $account): self
    {
        return new self(
            sprintf(
                'Account with type [ %s ] and uuid [ %s ] not found',
                $accountType,
                $account
                    ->getUuid()
                    ->getValue()
            )
        );
    }
}
