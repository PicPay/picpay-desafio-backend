<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Domain\Transaction\Repository\TransactionRepositoryInterface;

final class ListService implements ListServiceInterface
{
    use TransactionRepositoryHelperTrait;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->setTransactionRepository($transactionRepository);
    }

    public function handleList(): TransactionCollection
    {
        return $this
            ->getTransactionRepository()
            ->list()
        ;
    }
}
