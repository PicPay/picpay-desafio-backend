<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Service\MoneyTransfer\Validator\ExternalValidatorInterface;

interface TransactionValidatorServiceInterface
{
    public function addExternalValidator(ExternalValidatorInterface $externalValidator): bool;

    public function hasExternalValidator(ExternalValidatorInterface $externalValidator): bool;

    public function handleValidate(MoneyTransfer $moneyTransfer): void;
}
