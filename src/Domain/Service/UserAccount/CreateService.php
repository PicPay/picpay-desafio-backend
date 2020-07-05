<?php

declare(strict_types=1);

namespace App\Domain\Service\UserAccount;

use App\Domain\Entity\UserAccount;
use App\Domain\Exception\Service\UserAccount\CreateService\UserAccountFoundException;
use App\Domain\Repository\UserAccountRepositoryInterface;
use App\Domain\ValueObject\Amount;

class CreateService
{
    private UserAccountRepositoryInterface $userAccountRepository;

    public function __construct(UserAccountRepositoryInterface $userAccountRepository)
    {
        $this->userAccountRepository = $userAccountRepository;
    }

    public function createUserAccount(UserAccount $userAccount): UserAccount
    {
        if ($this->hasUserAccount($userAccount)) {
            throw UserAccountFoundException::handle($userAccount->getDocument());
        }

        $userAccount->setBalance(new Amount(0));

        return $this
            ->userAccountRepository
            ->create($userAccount)
        ;
    }

    private function hasUserAccount(UserAccount $userAccount): bool
    {
        return $this
            ->userAccountRepository
            ->hasByDocument($userAccount->getDocument())
        ;
    }
}
