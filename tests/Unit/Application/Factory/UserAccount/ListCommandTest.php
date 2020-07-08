<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Factory\UserAccount;

use App\Application\Command\UserAccount\ListCommand;
use App\Domain\UserAccount\Entity\AccountCollection;
use App\Domain\UserAccount\Service\ListServiceInterface;
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
            ->andReturn(new AccountCollection())
        ;
        $logger = Mockery::mock(LoggerInterface::class);

        $listCommand = new ListCommand($service, $logger);
        $accountCollectionGot = $listCommand->execute();

        self::assertInstanceOf(AccountCollection::class, $accountCollectionGot);
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
