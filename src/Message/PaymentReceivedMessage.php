<?php


namespace App\Message;


use App\Entity\Transaction;

class PaymentReceivedMessage
{
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }
}