<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Repository\AccountRepositoryInterface;

trait AccountRepositoryHelperTrait
{
    private AccountRepositoryInterface $accountRepository;

    protected function getAccountRepository(): AccountRepositoryInterface
    {
        return $this->accountRepository;
    }

    protected function setAccountRepository(AccountRepositoryInterface $accountRepository): void
    {
        $this->accountRepository = $accountRepository;
    }
}
