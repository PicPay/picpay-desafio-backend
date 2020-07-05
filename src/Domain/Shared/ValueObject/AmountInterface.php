<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

interface AmountInterface
{
    public function getValue(): int;

    public function getValueDecimal(): float;
}
