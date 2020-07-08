<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Exception\Service\MoneyTransfer\Validator;

use RuntimeException;

class ExternalValidatorValidationException extends RuntimeException
{
    public static function handle(string $reason): self
    {
        return new self($reason);
    }
}
