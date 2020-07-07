<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

interface TransactionAmountInterface extends AmountInterface
{
    public static function isValid(int $value): bool;
}
