<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Cache;

use App\Infrastructure\ORM\Entity\Account as AccountORM;

interface TransactionCacheInterface
{
    public function registerBalance(AccountORM $accountORM): void;

    public function getBalance(AccountORM $accountORM): ?int;
}
