<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Domain\Transaction\DTO;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transaction\Account;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Infrastructure\Domain\Transaction\DTO\TransactionDTO;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TransactionDTOTest extends TestCase
{
    public function testToArray(): void
    {
        $transactionDTO = new TransactionDTO($this->getTransaction());
        self::assertIsArray($transactionDTO->toArray());
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
