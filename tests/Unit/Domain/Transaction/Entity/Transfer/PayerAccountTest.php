<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transfer;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;
use PHPUnit\Framework\TestCase;

class PayerAccountTest extends TestCase
{
    public function testAttributes(): void
    {
        $uuidExpected = new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e');
        $documentExpected = new Document('57588899034');
        $balanceExpected = new BalanceAmount(1250);

        $payerAccount = new PayerAccount();
        $payerAccount->setUuid($uuidExpected);
        $payerAccount->setDocument($documentExpected);
        $payerAccount->setBalance($balanceExpected);

        self::assertEquals($uuidExpected, $payerAccount->getUuid());
        self::assertEquals($documentExpected, $payerAccount->getDocument());
        self::assertEquals($balanceExpected, $payerAccount->getBalance());
    }

    public function testIsCommercialEstablishment(): void
    {
        $payerAccount = new PayerAccount();
        $payerAccount->setDocument(new Document('81552812000141'));

        self::assertTrue($payerAccount->isCommercialEstablishment());
    }

    public function testIsNotCommercialEstablishment(): void
    {
        $payerAccount = new PayerAccount();
        $payerAccount->setDocument(new Document('57588899034'));

        self::assertFalse($payerAccount->isCommercialEstablishment());
    }
}
