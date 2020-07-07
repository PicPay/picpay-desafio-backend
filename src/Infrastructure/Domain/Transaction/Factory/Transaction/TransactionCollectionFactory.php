<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Factory\Transaction;

use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Infrastructure\ORM\Entity\Transaction as TransactionORM;

class TransactionCollectionFactory
{
    public static function createFromORM(array $ormData): TransactionCollection
    {
        $transactionCollection = new TransactionCollection();

        /** @var TransactionORM $transactionORM */
        foreach ($ormData as $transactionORM) {
            $transactionCollection->add(
                TransactionFactory::createFromORM($transactionORM)
            );
        }

        return $transactionCollection;
    }
}
