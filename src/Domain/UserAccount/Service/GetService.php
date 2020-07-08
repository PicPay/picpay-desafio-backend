<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Exception\Service\GetService\AccountNotFoundException;

final class GetService extends AbstractService implements GetServiceInterface
{
    public function handleGet(string $accountUuid): Account
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
