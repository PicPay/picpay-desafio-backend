<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\UserAccount\Service;

use App\Domain\Shared\ValueObject\Amount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Exception\Service\CreateService\AccountFoundException;
use App\Domain\UserAccount\Repository\AccountRepositoryInterface;
use App\Domain\UserAccount\Service\CreateService;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateServiceTest extends TestCase
{
    public function testHandleCreate(): void
    {
        $document = new Document('57588899034');
        $account = $this->getAccount($document);

        $uuidExpected = new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e');
        $balanceExpected = new Amount(0);
        $createdAtExpected = new DateTime('2020-07-05');
        $accountExpected = clone $account;
        $accountExpected->setUuid($uuidExpected);
        $accountExpected->setBalance($balanceExpected);
        $accountExpected->setCreatedAt($createdAtExpected);

        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('hasByDocument')
            ->withArgs([$document])
            ->andReturn(false)
        ;
        $repository
            ->shouldReceive('create')
            ->withArgs([$account])
            ->andReturn($accountExpected)
        ;

        $createService = new CreateService($repository);
        $accountGot = $createService->handleCreate($account);

        self::assertEquals($uuidExpected, $accountGot->getUuid());
        self::assertEquals($createdAtExpected, $accountGot->getCreatedAt());
        self::assertEquals(0, $accountGot->getBalance()->getValue());
        self::assertNull($accountGot->getUpdatedAt());
    }

    public function testHandleCreateThrowAccountFoundException(): void
    {
        self::expectException(AccountFoundException::class);

        $document = new Document('57588899034');
        $account = $this->getAccount($document);

        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('hasByDocument')
            ->withArgs([$document])
            ->andReturn(true)
        ;

        $createService = new CreateService($repository);
        $createService->handleCreate($account);
    }

    private function getAccount(Document $document): Account
    {
        $account = new Account();
        $account->setFirstName(new Name('John'));
        $account->setLastName(new Name('Doe'));
        $account->setDocument($document);
        $account->setEmail(new Email('john@doe.com'));
        $account->setPassword('123456');

        return $account;
    }
}
