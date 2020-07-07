<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer\Validator;

use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;

interface ExternalValidatorInterface
{
    public function handleValidation(MoneyTransfer $moneyTransfer): void;
}
