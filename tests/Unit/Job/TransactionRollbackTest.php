<?php

namespace Tests\Unit\Job;

use Mockery;
use Tests\TestCase;
use App\Models\Transaction;
use App\Services\WalletService;
use App\Jobs\TransactionRollback;
use App\Events\TransactionProcessedError;

class TransactionRollbackTest extends TestCase
{
    public function testMustCallTheTransactionRollbackService()
    {
        $transaction = factory(Transaction::class)->make();

        $transactionProcessedError = Mockery::mock(TransactionProcessedError::class);
        $transactionProcessedError->shouldReceive('getTransaction')->andReturn($transaction);

        $walletService = Mockery::mock(WalletService::class);
        $walletService->shouldReceive('rollbackByTransaction')->with($transaction)->once();

        $transactionRollback = new TransactionRollback($walletService);

        $transactionRollback->handle($transactionProcessedError);
    }
}
