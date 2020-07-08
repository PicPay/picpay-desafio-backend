<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transaction;

use function array_search;
use function in_array;

final class TransactionCollection
{
    private array $transactions;

    public function __construct()
    {
        $this->transactions = [];
    }

    public function add(Transaction $transaction): bool
    {
        if ($this->has($transaction)) {
            return false;
        }

        $this->transactions[] = $transaction;
        return true;
    }

    public function has(Transaction $transaction): bool
    {
        return in_array($transaction, $this->transactions);
    }

    public function remove(Transaction $transaction): bool
    {
        if (!$this->has($transaction)) {
            return false;
        }

        $key = array_search($transaction, $this->transactions);
        unset($this->transactions[$key]);
        return true;
    }

    public function get(): array
    {
        return $this->transactions;
    }
}
