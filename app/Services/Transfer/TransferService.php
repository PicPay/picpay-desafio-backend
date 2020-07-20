<?php

namespace App\Services\Transfer;

use App\Jobs\TransferAuthorization;
use Model\Transactions\Repositories\TransactionsRepositoryInterface;
use DB;

class TransferService implements TransferServiceInterface
{
    private $transactionRepository;

    public function __construct(TransactionsRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function executeTransferTransaction($payer_id, $payee_id, $amount)
    {
        $transaction = $this->transactionRepository->add($payer_id,$payee_id,$amount);
        TransferAuthorization::dispatchNow($transaction->transaction_id);
        return $transaction->fresh();
    }


}
