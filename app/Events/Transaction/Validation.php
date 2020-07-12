<?php

namespace App\Events\Transaction;

use App\Events\Event;
use App\Models\Transaction\Transaction;
use Log;

class Validation extends Event
{
    public $transaction;
    public $payload;
    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $transaction, array $payload)
    {
        Log::info(__CLASS__);
        $this->transaction = $transaction;
        $this->payload = $payload;
        $this->status = Transaction::AUTHORIZED;
    }


    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
