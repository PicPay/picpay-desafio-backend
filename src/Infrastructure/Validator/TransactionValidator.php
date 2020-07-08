<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;

use function sprintf;

class TransactionValidator extends AbstractValidator
{
    protected function handleValidation(): void
    {
        if (!UuidV4::isValid($this->getValue('payerUuid'))) {
            $this->addError('payerUuid', 'param should be a valid account uuid');
        }

        if (!UuidV4::isValid($this->getValue('payeeUuid'))) {
            $this->addError('payeeUuid', 'param should be a valid account uuid');
        }

        if (!TransactionAmount::isValid($this->getValue('amount'))) {
            $this->addError(
                'amount',
                sprintf('minimum amount allowed to transfer is [ %d ]', TransactionAmount::VALUE_MINIMUM)
            );
        }
    }
}
