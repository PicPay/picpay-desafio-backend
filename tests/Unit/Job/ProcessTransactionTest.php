<?php

namespace Tests\Unit\Job;

use Mockery;
use Tests\TestCase;
use App\Models\Transaction;
use App\Jobs\ProcessTransaction;
use App\Events\CreateTransaction;
use App\Services\TransactionService;

class ProcessTransactionTest extends TestCase
{
    public function testMustCallTransactionProcessing()
    {
        $transaction = factory(Transaction::class)->make();

        $createTransaction = Mockery::mock(CreateTransaction::class);
        $createTransaction->shouldReceive('getTransaction')->once()->andReturn($transaction);

        $transactionService = Mockery::mock(TransactionService::class);
        $transactionService->shouldReceive('process')->with($transaction)->once();


        $processTransaction = new ProcessTransaction($transactionService);

        $processTransaction->handle($createTransaction);
    }
}
