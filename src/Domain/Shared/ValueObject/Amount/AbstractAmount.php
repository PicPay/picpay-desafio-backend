<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Amount;

use function sprintf;
use function substr;

abstract class AbstractAmount
{
    protected int $value;

    abstract public function __construct(int $value);

    public function getValue(): int
    {
        return $this->value;
    }

    public function getValueDecimal(): string
    {
        if (100 > $this->getValue()) {
            return sprintf('0.%d', $this->getValue());
        }

        $valueString = (string) $this->getValue();

        return sprintf(
            '%s.%s',
            substr($valueString, 0, -2),
            substr($valueString, -2)
        );
    }
}
