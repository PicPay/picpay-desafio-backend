<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Amount;

use App\Domain\Shared\Exception\ValueObject\Amount\TransactionAmount\InvalidValueException;

final class TransactionAmount extends AbstractAmount implements TransactionAmountInterface
{
    const VALUE_MINIMUM = 1;

    public function __construct(int $value)
    {
        if (!self::isValid($value)) {
            throw InvalidValueException::handleLessThanMinimum($value, self::VALUE_MINIMUM);
        }

        $this->value = $value;
    }

    public static function isValid(int $value): bool
    {
        return self::VALUE_MINIMUM <= $value;
    }
}
