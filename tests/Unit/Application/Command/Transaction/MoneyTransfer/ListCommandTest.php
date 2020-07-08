<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Command\Transaction\MoneyTransfer;

use App\Application\Command\Transaction\MoneyTransfer\ListCommand;
use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Domain\Transaction\Service\MoneyTransfer\ListServiceInterface;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ListCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $service = Mockery::mock(ListServiceInterface::class);
        $service
            ->shouldReceive('handleList')
            ->andReturn(new TransactionCollection())
        ;
        $logger = Mockery::mock(LoggerInterface::class);

        $listCommand = new ListCommand($service, $logger);
        $transactionCollectionGot = $listCommand->execute();

        self::assertInstanceOf(TransactionCollection::class, $transactionCollectionGot);
    }

    public function testExecuteThrowException(): void
    {
        self::expectException(Exception::class);

        $service = Mockery::mock(ListServiceInterface::class);
        $service
            ->shouldReceive('handleList')
            ->andThrow(Exception::class)
        ;
        $logger = Mockery::mock(LoggerInterface::class);
        $logger
            ->shouldReceive('error')
            ->andReturn(null)
        ;

        $listCommand = new ListCommand($service, $logger);
        $listCommand->execute();
    }
}
