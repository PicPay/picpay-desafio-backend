<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService;

use RuntimeException;

class CuteEasterEggException extends RuntimeException
{
    public static function handle(): self
    {
        return new self('Seu bobinho, você não pode fazer uma transferência para si mesmo :)');
    }
}
