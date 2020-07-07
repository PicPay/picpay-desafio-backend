<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service;

use App\Domain\Transaction\Entity\MoneyTransfer;

class MoneyTransferService
{
    public function handleTransfer(MoneyTransfer $moneyTransfer): MoneyTransfer
    {
        dd($moneyTransfer);
        return $moneyTransfer;
    }
}
