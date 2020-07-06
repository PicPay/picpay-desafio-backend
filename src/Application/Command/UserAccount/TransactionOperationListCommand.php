<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Domain\UserAccount\Entity\TransactionOperationCollection;
use App\Domain\UserAccount\Service\TransactionOperationListService;

class TransactionOperationListCommand
{
    private TransactionOperationListService $transactionOperationListService;

    public function __construct(TransactionOperationListService $transactionOperationListService)
    {
        $this->transactionOperationListService = $transactionOperationListService;
    }

    public function execute(string $accountUuid): TransactionOperationCollection
    {
        return $this
            ->transactionOperationListService
            ->handleList($accountUuid)
        ;
    }
}
