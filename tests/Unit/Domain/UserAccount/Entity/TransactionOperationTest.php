<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\UserAccount\Entity;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transfer\Account\Operation\Type\TransactionOut;
use App\Domain\UserAccount\Entity\TransactionOperation;
use PHPUnit\Framework\TestCase;

class TransactionOperationTest extends TestCase
{
    public function testAttributes(): void
    {
        $uuidExpected = new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e');
        $typeExpected = (new TransactionOut())->getType();
        $authenticationExpected = 'BR8166940296824476522617194O9';
        $transactionAmountExpected = new TransactionAmount(1250);
        $payerDocumentExpected = new Document('57588899034');
        $payeeDocumentExpected = new Document('26693802044');

        $transactionOperation = new TransactionOperation();
        $transactionOperation->setUuid($uuidExpected);
        $transactionOperation->setType($typeExpected);
        $transactionOperation->setAuthentication($authenticationExpected);
        $transactionOperation->setAmount($transactionAmountExpected);
        $transactionOperation->setPayerDocument($payerDocumentExpected);
        $transactionOperation->setPayeeDocument($payeeDocumentExpected);

        self::assertEquals($uuidExpected, $transactionOperation->getUuid());
        self::assertEquals($typeExpected, $transactionOperation->getType());
        self::assertEquals($authenticationExpected, $transactionOperation->getAuthentication());
        self::assertEquals($transactionAmountExpected, $transactionOperation->getAmount());
        self::assertEquals($payerDocumentExpected, $transactionOperation->getPayerDocument());
        self::assertEquals($payeeDocumentExpected, $transactionOperation->getPayeeDocument());
    }
}
