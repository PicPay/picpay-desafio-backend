<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Factory\UserAccount;

use App\Application\Command\UserAccount\GetCommand;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Service\GetServiceInterface;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class GetCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $accountUuid = '89b4e999-ebda-45f8-91e6-3500b7993772';
        $service = Mockery::mock(GetServiceInterface::class);
        $service
            ->shouldReceive('handleGet')
            ->withArgs([$accountUuid])
            ->andReturn(new Account())
        ;
        $logger = Mockery::mock(LoggerInterface::class);

        $getCommand = new GetCommand($service, $logger);
        $accountGot = $getCommand->execute($accountUuid);

        self::assertInstanceOf(Account::class, $accountGot);
    }

    public function testExecuteThrowException(): void
    {
        self::expectException(Exception::class);

        $accountUuid = '89b4e999-ebda-45f8-91e6-3500b7993772';
        $service = Mockery::mock(GetServiceInterface::class);
        $service
            ->shouldReceive('handleGet')
            ->withArgs([$accountUuid])
            ->andThrow(Exception::class)
        ;
        $logger = Mockery::mock(LoggerInterface::class);
        $logger
            ->shouldReceive('error')
            ->andReturn(null)
        ;

        $getCommand = new GetCommand($service, $logger);
        $getCommand->execute($accountUuid);
    }
}
