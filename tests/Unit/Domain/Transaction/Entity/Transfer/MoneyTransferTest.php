<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transfer;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;
use PHPUnit\Framework\TestCase;

class MoneyTransferTest extends TestCase
{
    public function testAttributes(): void
    {
        $payerAccountExpected = $this->getPayerAccount();
        $payeeAccountExpected = $this->getPayeeAccount();
        $transferAmountExpected = new TransactionAmount(1250);

        $moneyTransfer = new MoneyTransfer();
        $moneyTransfer->setPayerAccount($payerAccountExpected);
        $moneyTransfer->setPayeeAccount($payeeAccountExpected);
        $moneyTransfer->setTransferAmount($transferAmountExpected);

        self::assertEquals($payerAccountExpected, $moneyTransfer->getPayerAccount());
        self::assertEquals($payeeAccountExpected, $moneyTransfer->getPayeeAccount());
        self::assertEquals($transferAmountExpected, $moneyTransfer->getTransferAmount());
    }

    private function getPayerAccount(): PayerAccount
    {
        $payerAccount = new PayerAccount();
        $payerAccount->setUuid(new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e'));
        $payerAccount->setDocument(new Document('57588899034'));
        $payerAccount->setBalance(new BalanceAmount(1250));

        return $payerAccount;
    }

    private function getPayeeAccount(): PayeeAccount
    {
        $payeeAccount = new PayeeAccount();
        $payeeAccount->setUuid(new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e'));

        return $payeeAccount;
    }
}
