<?php

namespace Tests\Unit\Events;

use Tests\TestCase;
use App\Events\TransactionProcessedError;
use App\Models\Transaction;

class TransactionProcessedErrorTest extends TestCase
{
    public function testMustReturnATransaction()
    {
        $transaction = factory(Transaction::class)->make();

        $transactionProcessedError = new TransactionProcessedError($transaction);

        $this->assertEquals($transaction, $transactionProcessedError->getTransaction());
    }
}
