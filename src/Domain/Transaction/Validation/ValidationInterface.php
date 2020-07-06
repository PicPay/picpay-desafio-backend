<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Validation;

use App\Domain\Transaction\Entity\MoneyTransfer;

interface ValidationInterface
{
    public function handleValidation(MoneyTransfer $moneyTransfer): void;
}
