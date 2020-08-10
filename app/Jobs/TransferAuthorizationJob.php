<?php

namespace App\Jobs;

use App\Exceptions\Transaction\ErrorOnTransactionAuthorization;
use App\Services\Authorization\CheckAuthorizationService;
use App\Services\Transfer\FinishTransferService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Log;
use Model\Transactions\Repositories\TransactionsRepositoryInterface;

class TransferAuthorizationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $maxExceptions = 3;

    private $transaction_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CheckAuthorizationService $checkAuthorizationService, FinishTransferService $finishTransferService)
    {
        try {
            if ($checkAuthorizationService->executeCheckAuthorization($this->transaction_id)) {
                $finishTransferService->executeFinishAuthorizedTransaction($this->transaction_id);
            } else {
                $finishTransferService->executeRollbackFailedTransaction($this->transaction_id);
            }
            return true;
        } catch (\Exception $e) {
            throw new ErrorOnTransactionAuthorization("Authorization service unavailable");
        }
        return false;
    }
}
