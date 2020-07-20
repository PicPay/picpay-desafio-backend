<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Queue\SerializesModels;

class ReceiveTransactions
{
    use SerializesModels;

    private $transaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function transaction() : Transaction
    {
        return $this->transaction;
    }
}
