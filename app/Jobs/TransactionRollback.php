<?php

namespace App\Jobs;

use App\Services\WalletService;
use App\Events\TransactionProcessedError;

class TransactionRollback
{
    private $walletService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TransactionProcessedError $transactionProcessedError): void
    {
        $this->walletService->rollbackByTransaction($transactionProcessedError->getTransaction());
    }
}
