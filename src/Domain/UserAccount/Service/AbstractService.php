<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\UserAccount\Repository\AccountRepositoryInterface;

abstract class AbstractService
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    protected function getRepository(): AccountRepositoryInterface
    {
        return $this->accountRepository;
    }
}
