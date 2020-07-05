<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\ValueObject\Amount\InvalidValueException;

final class Amount implements AmountInterface
{
    const VALUE_MINIMUM = 0;

    private int $value;

    public function __construct(int $value)
    {
        if (self::VALUE_MINIMUM > $value) {
            throw InvalidValueException::handleLessThanMinimum($value, self::VALUE_MINIMUM);
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
