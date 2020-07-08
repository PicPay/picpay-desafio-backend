<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\UserAccount\Service;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transfer\Account\Operation\Type\TransactionOut;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Entity\TransactionOperation;
use App\Domain\UserAccount\Entity\TransactionOperationCollection;
use App\Domain\UserAccount\Exception\Service\GetService\AccountNotFoundException;
use App\Domain\UserAccount\Repository\AccountRepositoryInterface;
use App\Domain\UserAccount\Service\TransactionOperationListService;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransactionOperationListServiceTest extends TestCase
{
    public function testHandleList(): void
    {
        $uuid = 'fa24ccc6-26eb-48c1-8ceb-b9356dfca98e';
        $account = $this->getAccount($uuid);
        $transactionOperationCollectionExpected = $this->getTransactionOperationCollection();

        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('get')
            ->withArgs([$uuid])
            ->andReturn($account)
        ;
        $repository
            ->shouldReceive('listTransactionOperations')
            ->withArgs([$account])
            ->andReturn($transactionOperationCollectionExpected)
        ;

        $transactionOperationListService = new TransactionOperationListService($repository);
        $transactionOperationCollectionGot = $transactionOperationListService->handleList($uuid);

        self::assertEquals($transactionOperationCollectionExpected, $transactionOperationCollectionGot);
    }

    public function testHandleCreateThrowAccountFoundException(): void
    {
        self::expectException(AccountNotFoundException::class);

        $uuid = 'fa24ccc6-26eb-48c1-8ceb-b9356dfca98e';

        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('get')
            ->withArgs([$uuid])
            ->andReturn(null)
        ;

        $transactionOperationListService = new TransactionOperationListService($repository);
        $transactionOperationListService->handleList($uuid);
    }

    private function getAccount(string $uuid): Account
    {
        $account = new Account();
        $account->setUuid(new UuidV4($uuid));
        $account->setFirstName(new Name('John'));
        $account->setLastName(new Name('Doe'));
        $account->setDocument(new Document('57588899034'));
        $account->setEmail(new Email('john@doe.com'));
        $account->setPassword('123456');

        return $account;
    }

    private function getTransactionOperationCollection(): TransactionOperationCollection
    {
        $transactionOperation = new TransactionOperation();
        $transactionOperation->setUuid(
            new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e')
        );
        $transactionOperation->setType((new TransactionOut())->getType());
        $transactionOperation->setAuthentication('BR8166940296824476522617194O9');
        $transactionOperation->setAmount(new TransactionAmount(1250));
        $transactionOperation->setPayerDocument(new Document('57588899034'));
        $transactionOperation->setPayeeDocument(new Document('26693802044'));

        $transactionOperationCollection = new TransactionOperationCollection();
        $transactionOperationCollection->add($transactionOperation);

        return $transactionOperationCollection;
    }
}
