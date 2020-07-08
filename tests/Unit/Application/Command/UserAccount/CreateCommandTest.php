<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Command\UserAccount;

use App\Application\Command\UserAccount\CreateCommand;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Service\CreateServiceInterface;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class CreateCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $requestData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'document' => '00412651068',
            'email' => 'john@doe.com',
            'password' => '123456',
        ];
        $service = Mockery::mock(CreateServiceInterface::class);
        $service
            ->shouldReceive('handleCreate')
            ->andReturn(new Account())
        ;
        $logger = Mockery::mock(LoggerInterface::class);

        $createCommand = new CreateCommand($service, $logger);
        $accountGot = $createCommand->execute($requestData);
        self::assertInstanceOf(Account::class, $accountGot);
    }

    public function testExecuteThrowException(): void
    {
        self::expectException(Exception::class);

        $requestData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'document' => '00412651068',
            'email' => 'john@doe.com',
            'password' => '123456',
        ];
        $service = Mockery::mock(CreateServiceInterface::class);
        $service
            ->shouldReceive('handleCreate')
            ->andThrow(Exception::class)
        ;
        $logger = Mockery::mock(LoggerInterface::class);
        $logger
            ->shouldReceive('error')
            ->andReturn(null)
        ;

        $createCommand = new CreateCommand($service, $logger);
        $createCommand->execute($requestData);
    }
}
