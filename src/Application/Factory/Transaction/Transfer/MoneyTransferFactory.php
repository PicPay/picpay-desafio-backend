<?php

declare(strict_types=1);

namespace App\Application\Factory\Transaction\Transfer;

use App\Domain\Shared\ValueObject\TransactionAmount;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;

class MoneyTransferFactory
{
    public static function createFromRequest(array $requestData): MoneyTransfer
    {
        $payerAccount = new PayerAccount();
        $payerAccount->setUuid(
            new UuidV4($requestData['payerUuid'])
        );

        $payeeAccount = new PayeeAccount();
        $payeeAccount->setUuid(
            new UuidV4($requestData['payeeUuid'])
        );

        $moneyTransfer = new MoneyTransfer();
        $moneyTransfer->setPayerAccount($payerAccount);
        $moneyTransfer->setPayeeAccount($payeeAccount);
        $moneyTransfer->setTransferAmount(
            new TransactionAmount($requestData['amount'])
        );

        return $moneyTransfer;
    }
}
