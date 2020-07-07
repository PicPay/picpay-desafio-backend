<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Repository\TransactionRepositoryInterface;

abstract class AbstractService
{
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    protected function getTransactionRepository(): TransactionRepositoryInterface
    {
        return $this->transactionRepository;
    }
}
