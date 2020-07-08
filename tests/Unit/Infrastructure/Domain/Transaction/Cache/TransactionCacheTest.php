<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Domain\Transaction\Cache;

use App\Infrastructure\Domain\Transaction\Cache\TransactionCache;
use App\Infrastructure\ORM\Entity\Account;
use Mockery;
use PHPUnit\Framework\TestCase;
use Predis\Client;
use function sprintf;

class TransactionCacheTest extends TestCase
{
    public function testRegisterBalance(): void
    {
        $account = new Account();
        $account->forgeUuid();
        $account->setBalance(1250);

        $balanceRollbackExpiration = 120;
        $client = Mockery::mock(Client::class);
        $client
            ->shouldReceive('setex')
            ->withArgs([
                sprintf('account_balance_%s', $account->getUuid()),
                $balanceRollbackExpiration,
                (string) $account->getBalance()
            ])
            ->andReturn(null)
        ;

        $transactionCache = new TransactionCache($client, $balanceRollbackExpiration);
        $transactionCache->registerBalance($account);

        self::assertTrue(true);
    }

    public function testGetBalance(): void
    {
        $account = new Account();
        $account->forgeUuid();
        $balanceExpected = 1250;

        $balanceRollbackExpiration = 120;
        $client = Mockery::mock(Client::class);
        $client
            ->shouldReceive('get')
            ->withArgs([
                sprintf('account_balance_%s', $account->getUuid()),
            ])
            ->andReturn((string) $balanceExpected)
        ;

        $transactionCache = new TransactionCache($client, $balanceRollbackExpiration);
        $balanceGot = $transactionCache->getBalance($account);

        self::assertEquals($balanceExpected, $balanceGot);
    }

    public function testGetBalanceNull(): void
    {
        $account = new Account();
        $account->forgeUuid();

        $balanceRollbackExpiration = 120;
        $client = Mockery::mock(Client::class);
        $client
            ->shouldReceive('get')
            ->withArgs([
                sprintf('account_balance_%s', $account->getUuid()),
            ])
            ->andReturn(null)
        ;

        $transactionCache = new TransactionCache($client, $balanceRollbackExpiration);
        $balanceGot = $transactionCache->getBalance($account);

        self::assertNull($balanceGot);
    }
}
