<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Amount;

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
        return 'xyz';
    }
}
