<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\ValueObject\TransactionAmount\InvalidValueException;

final class TransactionAmount implements TransactionAmountInterface
{
    const VALUE_MINIMUM = 1;

    protected int $value;

    public function __construct(int $value)
    {
        if (!self::isValid($value)) {
            throw InvalidValueException::handleLessThanMinimum($value, self::VALUE_MINIMUM);
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getValueDecimal(): float
    {
        return $this->getValue() / 100;
    }

    public static function isValid(int $value): bool
    {
        return self::VALUE_MINIMUM <= $value;
    }
}
