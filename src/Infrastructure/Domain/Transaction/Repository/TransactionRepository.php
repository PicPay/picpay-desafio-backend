<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Repository;

use App\Domain\Transaction\Entity\TransactionCollection;
use App\Domain\Transaction\Repository\TransactionRepositoryInterface;
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
        return new TransactionCollection();
    }
}
