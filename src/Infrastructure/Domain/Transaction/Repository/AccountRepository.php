<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Repository;

use App\Domain\Shared\ValueObject\Amount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;
use App\Infrastructure\ORM\Entity\Account as AccountORM;
use App\Infrastructure\ORM\Repository\AccountRepository as AccountRepositoryORM;

class AccountRepository implements AccountRepositoryInterface
{
    private AccountRepositoryORM $accountRepositoryORM;

    public function __construct(AccountRepositoryORM $accountRepositoryORM)
    {
        $this->accountRepositoryORM = $accountRepositoryORM;
    }

    public function getPayerAccount(PayerAccount $payerAccount): ?PayerAccount
    {
        $accountORM = $this
            ->accountRepositoryORM
            ->find(
                $payerAccount
                    ->getUuid()
                    ->getValue()
            )
        ;

        if (!$accountORM instanceof AccountORM) {
            return null;
        }

        $payerAccount->setDocument(
            new Document($accountORM->getDocumentNumber())
        );

        $payerAccount->setBalance(
            new Amount($accountORM->getBalance())
        );

        return $payerAccount;
    }

    public function hasPayeeAccount(PayeeAccount $payeeAccount): bool
    {
        $accountORM = $this
            ->accountRepositoryORM
            ->find(
                $payeeAccount
                    ->getUuid()
                    ->getValue()
            )
        ;

        return $accountORM instanceof AccountORM;
    }
}
