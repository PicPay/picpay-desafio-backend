<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;

interface AccountTransactionBalanceServiceInterface
{
    public function updateBalance(MoneyTransfer $moneyTransfer): void;

    public function rollbackBalance(MoneyTransfer $moneyTransfer): void;
}
