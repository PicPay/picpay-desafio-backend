<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\Shared\ValueObject\Amount;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Exception\Service\CreateService\AccountFoundException;
use App\Domain\UserAccount\Repository\AccountRepositoryInterface;

final class CreateService
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function handleCreate(Account $account): Account
    {
        if ($this->hasUserAccount($account)) {
            throw AccountFoundException::handle($account->getDocument());
        }

        $account->setBalance(new Amount(0));

        return $this
            ->accountRepository
            ->create($account)
        ;
    }

    private function hasUserAccount(Account $account): bool
    {
        return $this
            ->accountRepository
            ->hasByDocument($account->getDocument())
        ;
    }
}
