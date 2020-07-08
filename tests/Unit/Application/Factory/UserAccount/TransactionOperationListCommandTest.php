<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Factory\UserAccount;

use App\Application\Command\UserAccount\TransactionOperationListCommand;
use App\Domain\UserAccount\Entity\TransactionOperationCollection;
use App\Domain\UserAccount\Service\TransactionOperationListServiceInterface;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class TransactionOperationListCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $accountUuid = '89b4e999-ebda-45f8-91e6-3500b7993772';

        $service = Mockery::mock(TransactionOperationListServiceInterface::class);
        $service
            ->shouldReceive('handleList')
            ->withArgs([$accountUuid])
            ->andReturn(new TransactionOperationCollection())
        ;
        $logger = Mockery::mock(LoggerInterface::class);

        $transactionOperationListCommand = new TransactionOperationListCommand($service, $logger);
        $transactionOperationCollection = $transactionOperationListCommand->execute($accountUuid);

        self::assertInstanceOf(TransactionOperationCollection::class, $transactionOperationCollection);
    }

    public function testExecuteThrowException(): void
    {
        self::expectException(Exception::class);

        $accountUuid = '89b4e999-ebda-45f8-91e6-3500b7993772';

        $service = Mockery::mock(TransactionOperationListServiceInterface::class);
        $service
            ->shouldReceive('handleList')
            ->withArgs([$accountUuid])
            ->andThrow(Exception::class)
        ;
        $logger = Mockery::mock(LoggerInterface::class);
        $logger
            ->shouldReceive('error')
            ->andReturn(null)
        ;

        $transactionOperationListCommand = new TransactionOperationListCommand($service, $logger);
        $transactionOperationListCommand->execute($accountUuid);
    }
}
