<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Repository;

use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Domain\Transaction\Repository\TransactionRepositoryInterface;
use App\Infrastructure\Domain\Transaction\Factory\Transaction\TransactionCollectionFactory;
use App\Infrastructure\ORM\Repository\TransactionRepository as TransactionRepositoryORM;

class TransactionRepository implements TransactionRepositoryInterface
{
    private TransactionRepositoryORM $transactionRepositoryORM;

    public function __construct(TransactionRepositoryORM $transactionRepositoryORM)
    {
        $this->transactionRepositoryORM = $transactionRepositoryORM;
    }

    public function list(): TransactionCollection
    {
        $transactionsORM = $this
            ->transactionRepositoryORM
            ->findBy([], ['createdAt' => 'desc'])
        ;

        return TransactionCollectionFactory::createFromORM($transactionsORM);
    }
}
