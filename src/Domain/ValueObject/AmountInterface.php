<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

interface AmountInterface
{
    public function getValue(): int;
}
