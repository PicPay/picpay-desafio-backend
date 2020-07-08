<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\UserAccount\Entity\Account;

interface GetServiceInterface
{
    public function handleGet(string $accountUuid): Account;
}
