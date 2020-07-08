<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Command\Transaction\MoneyTransfer;

use App\Application\Command\Transaction\MoneyTransfer\TransferCommand;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Service\MoneyTransfer\TransferServiceInterface;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class TransferCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $requestData = [
            'payerUuid' => '89b4e999-ebda-45f8-91e6-3500b7993772',
            'payeeUuid' => 'a01e3d27-0279-4968-9a84-641c82522ac6',
            'amount' => 1250,
        ];
        $service = Mockery::mock(TransferServiceInterface::class);
        $service
            ->shouldReceive('handleTransfer')
            ->andReturn(new Transaction())
        ;
        $logger = Mockery::mock(LoggerInterface::class);

        $transferCommand = new TransferCommand($service, $logger);
        $transactionGot = $transferCommand->execute($requestData);

        self::assertInstanceOf(Transaction::class, $transactionGot);
    }

    public function testExecuteThrowException(): void
    {
        self::expectException(Exception::class);

        $requestData = [
            'payerUuid' => '89b4e999-ebda-45f8-91e6-3500b7993772',
            'payeeUuid' => 'a01e3d27-0279-4968-9a84-641c82522ac6',
            'amount' => 1250,
        ];
        $service = Mockery::mock(TransferServiceInterface::class);
        $service
            ->shouldReceive('handleTransfer')
            ->andThrow(Exception::class)
        ;
        $logger = Mockery::mock(LoggerInterface::class);
        $logger
            ->shouldReceive('error')
            ->andReturn(null)
        ;

        $transferCommand = new TransferCommand($service, $logger);
        $transactionGot = $transferCommand->execute($requestData);
    }
}
