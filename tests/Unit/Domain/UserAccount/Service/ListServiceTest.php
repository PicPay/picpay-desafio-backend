<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\UserAccount\Service;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Entity\AccountCollection;
use App\Domain\UserAccount\Repository\AccountRepositoryInterface;
use App\Domain\UserAccount\Service\ListService;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ListServiceTest extends TestCase
{
    public function testHandleList(): void
    {
        $accountCollectionExpected = $this->getAccountCollection();

        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('list')
            ->andReturn($accountCollectionExpected)
        ;

        $listService = new ListService($repository);
        $accountCollectionGot = $listService->handleList();

        self::assertEquals($accountCollectionExpected, $accountCollectionGot);
    }

    private function getAccountCollection(): AccountCollection
    {
        $account = new Account();
        $account->setUuid(
            new UuidV4(
                Uuid
                    ::uuid4()
                    ->toString()
            )
        );
        $account->setFirstName(new Name('John'));
        $account->setLastName(new Name('Doe'));
        $account->setDocument(new Document('57588899034'));
        $account->setEmail(new Email('john@doe.com'));
        $account->setPassword('123456');
        $account->setBalance(new BalanceAmount(10));
        $account->setCreatedAt(new DateTime('2020-07-05'));

        $accountCollection = new AccountCollection();
        $accountCollection->add($account);

        return $accountCollection;
    }
}
