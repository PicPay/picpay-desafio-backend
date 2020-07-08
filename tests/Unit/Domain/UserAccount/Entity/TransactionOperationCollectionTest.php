<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\UserAccount\Entity;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transfer\Account\Operation\Type\TransactionOut;
use App\Domain\UserAccount\Entity\TransactionOperation;
use App\Domain\UserAccount\Entity\TransactionOperationCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TransactionOperationCollectionTest extends TestCase
{
    public function testAttributes(): void
    {
        $transactionOperationOne = $this->getTransactionOperation();
        $transactionOperationTwo = $this->getTransactionOperation();

        $transactionOperationCollection = new TransactionOperationCollection();

        self::assertCount(0, $transactionOperationCollection->get());
        self::assertTrue($transactionOperationCollection->add($transactionOperationOne));
        self::assertFalse($transactionOperationCollection->add($transactionOperationOne));

        self::assertFalse($transactionOperationCollection->has($transactionOperationTwo));
        $transactionOperationCollection->add($transactionOperationTwo);
        self::assertTrue($transactionOperationCollection->has($transactionOperationTwo));

        self::assertTrue($transactionOperationCollection->remove($transactionOperationTwo));
        self::assertFalse($transactionOperationCollection->remove($transactionOperationTwo));

        self::assertCount(1, $transactionOperationCollection->get());
    }

    private function getTransactionOperation(): TransactionOperation
    {
        $transactionOperation = new TransactionOperation();
        $transactionOperation->setUuid(
            new UuidV4(
                Uuid
                    ::uuid4()
                    ->toString()
            )
        );
        $transactionOperation->setType((new TransactionOut())->getType());
        $transactionOperation->setAuthentication('BR8166940296824476522617194O9');
        $transactionOperation->setAmount(new TransactionAmount(1250));
        $transactionOperation->setPayerDocument(new Document('57588899034'));
        $transactionOperation->setPayeeDocument(new Document('26693802044'));

        return $transactionOperation;
    }
}
