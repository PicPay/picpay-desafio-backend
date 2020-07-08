<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Exception\Service\CreateService\AccountFoundException;

final class CreateService extends AbstractService
{
    public function handleCreate(Account $account): Account
    {
        if ($this->hasUserAccount($account)) {
            throw AccountFoundException::handle($account->getDocument());
        }

        $account->setBalance(new BalanceAmount(0));

        return $this
            ->getRepository()
            ->create($account)
        ;
    }

    private function hasUserAccount(Account $account): bool
    {
        return $this
            ->getRepository()
            ->hasByDocument($account->getDocument())
        ;
    }
}
