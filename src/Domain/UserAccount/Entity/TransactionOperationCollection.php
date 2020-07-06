<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Entity;

use function array_search;
use function in_array;

final class TransactionOperationCollection
{
    private array $transactionOperations;

    public function __construct()
    {
        $this->transactionOperations = [];
    }

    public function add(TransactionOperation $transactionOperation): bool
    {
        if ($this->has($transactionOperation)) {
            return false;
        }

        $this->transactionOperations[] = $transactionOperation;
        return true;
    }

    public function has(TransactionOperation $transactionOperation): bool
    {
        return in_array($transactionOperation, $this->transactionOperations);
    }

    public function remove(TransactionOperation $transactionOperation): bool
    {
        if (!$this->has($transactionOperation)) {
            return false;
        }

        $key = array_search($transactionOperation, $this->transactionOperations);
        unset($this->transactionOperations[$key]);
        return true;
    }

    public function get(): array
    {
        return $this->transactionOperations;
    }
}
