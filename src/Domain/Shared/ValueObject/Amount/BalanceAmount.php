<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Amount;

use App\Domain\Shared\Exception\ValueObject\Amount\BalanceAmount\InvalidValueException;

final class BalanceAmount extends AbstractAmount implements BalanceAmountInterface
{
    const VALUE_MINIMUM = 0;

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
