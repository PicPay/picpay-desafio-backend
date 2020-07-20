<?php

namespace Tests\Unit\Events;

use Tests\TestCase;
use App\Events\CreateTransaction;
use App\Models\Transaction;

class CreateTransactionTest extends TestCase
{
    public function testMustReturnATransaction()
    {
        $transaction = factory(Transaction::class)->make();

        $createTransaction = new CreateTransaction($transaction);

        $this->assertEquals($transaction, $createTransaction->getTransaction());
    }
}
