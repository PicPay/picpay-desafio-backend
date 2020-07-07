<?php

declare(strict_types=1);

namespace App\Application\Factory\Transaction;

use App\Domain\Shared\ValueObject\TransactionAmount;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\AccountPayee;
use App\Domain\Transaction\Entity\AccountPayer;
use App\Domain\Transaction\Entity\MoneyTransfer;

class MoneyTransferFactory
{
    public static function createFromRequest(array $requestData): MoneyTransfer
    {
        $accountPayer = new AccountPayer();
        $accountPayer->setUuid(
            new UuidV4($requestData['payerUuid'])
        );

        $accountPayee = new AccountPayee();
        $accountPayee->setUuid(
            new UuidV4($requestData['payeeUuid'])
        );

        $moneyTransfer = new MoneyTransfer();
        $moneyTransfer->setAccountPayer($accountPayer);
        $moneyTransfer->setAccountPayee($accountPayee);
        $moneyTransfer->setTransferAmount(
            new TransactionAmount($requestData['amount'])
        );

        return $moneyTransfer;
    }
}
