<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\UserAccount\Entity\TransactionOperationCollection;

interface TransactionOperationListServiceInterface
{
    public function handleList(string $accountUuid): TransactionOperationCollection;
}
