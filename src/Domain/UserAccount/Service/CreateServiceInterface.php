<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\UserAccount\Entity\Account;

interface CreateServiceInterface
{
    public function handleCreate(Account $account): Account;
}
