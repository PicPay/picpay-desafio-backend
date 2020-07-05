<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\UserAccount\Factory;

use App\Domain\Shared\ValueObject\Amount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\UserAccount\Entity\Account;
use App\Infrastructure\ORM\Entity\Account as AccountORM;

class AccountFactory
{
    public static function createFromORM(AccountORM $accountORM): Account
    {
        $account = new Account();

        $account->setUuid(
            new UuidV4($accountORM->getUuid())
        );
        $account->setFirstName(
            new Name($accountORM->getFirstName())
        );
        $account->setLastName(
            new Name($accountORM->getLastName())
        );
        $account->setDocument(
            new Document($accountORM->getDocumentNumber())
        );
        $account->setEmail(
            new Email($accountORM->getEmail())
        );
        $account->setPassword($accountORM->getPassword());
        $account->setBalance(
            new Amount($accountORM->getBalance())
        );
        $account->setCreatedAt($accountORM->getCreatedAt());
        $account->setUpdatedAt($accountORM->getUpdatedAt());

        return $account;
    }
}
