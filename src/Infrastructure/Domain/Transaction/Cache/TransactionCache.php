<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Cache;

use App\Infrastructure\ORM\Entity\Account as AccountORM;
use Predis\Client;

use function is_null;
use function sprintf;

class TransactionCache
{
    private Client $client;
    private int $balanceRollbackExpiration;

    public function __construct(Client $client, int $balanceRollbackExpiration)
    {
        $this->client = $client;
        $this->balanceRollbackExpiration = $balanceRollbackExpiration;
    }

    public function registerBalance(AccountORM $accountORM): void
    {
        $this
            ->client
            ->setex(
                $this->getBalanceKey($accountORM),
                $this->balanceRollbackExpiration,
                (string) $accountORM->getBalance()
            )
        ;
    }

    public function getBalance(AccountORM $accountORM): ?int
    {
        $balanceCache = $this
            ->client
            ->get($this->getBalanceKey($accountORM))
        ;

        if (is_null($balanceCache)) {
            return null;
        }

        return (int) $balanceCache;
    }

    private function getBalanceKey(AccountORM $accountORM): string
    {
        return sprintf('account_balance_%s', $accountORM->getUuid());
    }
}
