<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\UserAccount\Factory;

use App\Domain\UserAccount\Entity\AccountCollection;
use App\Infrastructure\ORM\Entity\Account as AccountORM;

class AccountCollectionFactory
{
    public static function createFromORM(array $ormData): AccountCollection
    {
        $accountCollection = new AccountCollection();

        /** @var AccountORM $accountORM */
        foreach ($ormData as $accountORM) {
            $accountCollection->add(
                AccountFactory::createFromORM($accountORM)
            );
        }

        return $accountCollection;
    }
}
