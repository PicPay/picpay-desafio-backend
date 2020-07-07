<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Builder;

use App\Infrastructure\ORM\Entity\Account;
use App\Infrastructure\ORM\Entity\Operation;
use App\Infrastructure\ORM\Entity\Transaction;

class OperationBuilder
{
    private Operation $operation;

    public function __construct()
    {
        $this->operation = new Operation();
    }

    public function addType(string $type): self
    {
        $this
            ->operation
            ->setType($type)
        ;

        return $this;
    }

    public function addAccount(Account $account): self
    {
        $this
            ->operation
            ->setAccount($account)
        ;

        return $this;
    }

    public function addTransaction(Transaction $transaction): self
    {
        $this
            ->operation
            ->setTransaction($transaction)
        ;

        return $this;
    }

    public function get(): Operation
    {
        return $this->operation;
    }
}
