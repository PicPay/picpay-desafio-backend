<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\UserAccount\Factory;

use App\Domain\UserAccount\Entity\TransactionOperationCollection;
use App\Infrastructure\ORM\Entity\Operation as OperationORM;

class TransactionOperationCollectionFactory
{
    public static function createFromORM(array $ormData): TransactionOperationCollection
    {
        $transactionOperationCollection = new TransactionOperationCollection();

        /** @var OperationORM $operationORM */
        foreach ($ormData as $operationORM) {
            $transactionOperationCollection->add(
                TransactionOperationFactory::createFromORM($operationORM)
            );
        }

        return $transactionOperationCollection;
    }
}
