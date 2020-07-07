<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Repository;

use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;
use App\Infrastructure\ORM\Repository\AccountRepository as AccountRepositoryORM;

class AccountRepository implements AccountRepositoryInterface
{
    private AccountRepositoryORM $accountRepositoryORM;

    public function __construct(AccountRepositoryORM $accountRepositoryORM)
    {
        $this->accountRepositoryORM = $accountRepositoryORM;
    }

    public function getPayerAccount(PayerAccount $payerAccount): PayerAccount
    {
        return new PayerAccount();
    }

    public function hasPayeeAccount(PayeeAccount $payeeAccount): bool
    {
        return true;
    }
}
