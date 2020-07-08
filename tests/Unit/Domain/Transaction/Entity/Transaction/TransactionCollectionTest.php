<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transaction;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transaction\Account;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TransactionCollectionTest extends TestCase
{
    public function testAttributes(): void
    {
        $transactionOne = $this->getTransaction();
        $transactionTwo = $this->getTransaction();

        $transactionCollection = new TransactionCollection();

        self::assertCount(0, $transactionCollection->get());
        self::assertTrue($transactionCollection->add($transactionOne));
        self::assertFalse($transactionCollection->add($transactionOne));

        self::assertFalse($transactionCollection->has($transactionTwo));
        $transactionCollection->add($transactionTwo);
        self::assertTrue($transactionCollection->has($transactionTwo));

        self::assertTrue($transactionCollection->remove($transactionTwo));
        self::assertFalse($transactionCollection->remove($transactionTwo));

        self::assertCount(1, $transactionCollection->get());
    }

    private function getTransaction(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setUuid(
            new UuidV4(
                Uuid
                    ::uuid4()
                    ->toString()
            )
        );
        $transaction->setAccountPayer($this->getAccount());
        $transaction->setAccountPayee($this->getAccount());
        $transaction->setAmount(new TransactionAmount(1250));
        $transaction->setAuthentication('BR8166940296824476522617194O9');
        $transaction->setCreatedAt(new DateTime('2020-07-07 19:00:00'));

        return $transaction;
    }

    private function getAccount(): Account
    {
        $account = new Account();
        $account->setUuid(
            new UuidV4(
                Uuid
                    ::uuid4()
                    ->toString()
            )
        );
        $account->setDocument(new Document('57588899034'));

        return $account;
    }
}
