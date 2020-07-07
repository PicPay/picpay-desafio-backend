<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService;

use App\Domain\Transaction\Entity\Transfer\AbstractAccount;
use RuntimeException;
use function sprintf;

class InvalidPayerAccountException extends RuntimeException
{
    public static function handleNew(AbstractAccount $account): self
    {
        return new self(
            sprintf(
                'Invalid payer account, this account [ %s ] is commercial establishment '
                    . ' and can not do transfer to other accounts',
                $account
                    ->getUuid()
                    ->getValue()
            )
        );
    }
}
