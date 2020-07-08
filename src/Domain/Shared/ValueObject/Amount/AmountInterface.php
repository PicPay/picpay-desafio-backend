<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Amount;

interface AmountInterface
{
    public function getValue(): int;

    public function getValueDecimal(): string;

    public static function isValid(int $value): bool;
}
