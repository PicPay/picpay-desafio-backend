<?php

namespace App\Events;

use App\Models\Transaction;

class TransactionProcessedError extends Event
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }
}
