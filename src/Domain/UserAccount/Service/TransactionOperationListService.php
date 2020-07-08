<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Entity\TransactionOperationCollection;
use App\Domain\UserAccount\Exception\Service\GetService\AccountNotFoundException;

final class TransactionOperationListService extends AbstractService implements TransactionOperationListServiceInterface
{
    public function handleList(string $accountUuid): TransactionOperationCollection
    {
        $account = $this->getAccount($accountUuid);

        return $this
            ->getRepository()
            ->listTransactionOperations($account)
        ;
    }

    private function getAccount(string $accountUuid): Account
    {
        $account = $this
            ->getRepository()
            ->get($accountUuid)
        ;

        if (!$account instanceof Account) {
            throw AccountNotFoundException::handle($accountUuid);
        }

        return $account;
    }
}
