<?php

namespace App\Services\Transfer;

use App\Jobs\TransferAuthorizationJob;
use Illuminate\Database\QueryException;
use Model\Transactions\Repositories\TransactionsRepositoryInterface;
use Model\Transactions\Transactions;
use DB;
use Model\Users\Repositories\UsersRepositoryInterface;

class AddTransferService implements AddTransferServiceInterface
{
    private $transactionRepository;
    private $userRepository;

    public function __construct(TransactionsRepositoryInterface $transactionRepository,
UsersRepositoryInterface $userRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
    }

    public function executeAddTransfer($payer_id, $payee_id, $amount) : Transactions
    {
        DB::beginTransaction();
        try{
            $transaction = $this->transactionRepository->add($payer_id,$payee_id,$amount);
            $payer = $this->userRepository->withdrawCredit($payer_id,$amount);
            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();
        }

        TransferAuthorizationJob::dispatch($transaction->transaction_id);
        return $transaction;
    }
}
