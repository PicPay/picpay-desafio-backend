<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\UserAccount\Service;

use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Exception\Service\GetService\AccountNotFoundException;
use App\Domain\UserAccount\Repository\AccountRepositoryInterface;
use App\Domain\UserAccount\Service\GetService;
use Mockery;
use PHPUnit\Framework\TestCase;

class GetServiceTest extends TestCase
{
    public function testHandleGet(): void
    {
        $accountUuid = 'fa24ccc6-26eb-48c1-8ceb-b9356dfca98e';
        $accountExpected = $this->getAccount($accountUuid);

        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('get')
            ->withArgs([$accountUuid])
            ->andReturn($accountExpected)
        ;

        $getService = new GetService($repository);
        $accountGot = $getService->handleGet($accountUuid);

        self::assertEquals($accountExpected, $accountGot);
    }

    public function testHandleGetThrowAccountNotFoundException(): void
    {
        self::expectException(AccountNotFoundException::class);

        $accountUuid = 'fa24ccc6-26eb-48c1-8ceb-b9356dfca98e';

        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('get')
            ->withArgs([$accountUuid])
            ->andReturn(null)
        ;

        $getService = new GetService($repository);
        $getService->handleGet($accountUuid);
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
}
