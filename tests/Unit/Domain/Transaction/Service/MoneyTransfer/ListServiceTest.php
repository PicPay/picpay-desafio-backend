<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transaction\Account;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Domain\Transaction\Repository\TransactionRepositoryInterface;
use App\Domain\Transaction\Service\MoneyTransfer\ListService;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ListServiceTest extends TestCase
{
    public function testHandleList(): void
    {
        $transactionCollectionExpected = $this->getTransactionCollection();
        $repository = Mockery::mock(TransactionRepositoryInterface::class);
        $repository
            ->shouldReceive('list')
            ->andReturn($transactionCollectionExpected)
        ;

        $listService = new ListService($repository);
        $transactionCollectionGot = $listService->handleList();

        self::assertEquals($transactionCollectionExpected, $transactionCollectionGot);
    }

    private function getTransactionCollection(): TransactionCollection
    {
        $transactionCollection = new TransactionCollection();
        $transactionCollection->add($this->getTransaction());
        return $transactionCollection;
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
