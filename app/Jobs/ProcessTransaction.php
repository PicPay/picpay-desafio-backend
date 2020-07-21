<?php

namespace App\Jobs;

use App\Events\CreateTransaction;
use App\Services\TransactionService;

class ProcessTransaction extends Queue
{
    private $transactionService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CreateTransaction $createTransactionEvent): void
    {
        $this->transactionService->process($createTransactionEvent->getTransaction());
    }
}
