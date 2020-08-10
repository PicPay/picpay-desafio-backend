<?php

namespace App\Services\Transfer;

use App\Events\TransactionAuthorizedAndCompleted;
use App\Events\TransactionFailedAndRollbacked;
use App\Exceptions\Transaction\ErrorOnRollbackTransaction;
use App\Exceptions\Transaction\ErrorOnUpdatingTransactionToAuthorized;
use App\Jobs\TransferAuthorizationJob;
use DB;
use Illuminate\Database\QueryException;
use Model\Transactions\Repositories\TransactionsRepositoryInterface;
use Model\Transactions\Transactions;
use Model\Users\Repositories\UsersRepositoryInterface;

class FinishTransferService implements FinishTransferServiceInterface
{
    private $transactionRepository;
    private $userRepository;

    public function __construct(
        TransactionsRepositoryInterface $transactionRepository,
        UsersRepositoryInterface $userRepository
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
    }

    public function executeFinishAuthorizedTransaction($transaction_id): bool
    {
        DB::beginTransaction();
        try {
            $transaction = $this->transactionRepository->setAuthorized($transaction_id);
            $payee = $this->userRepository->addCredit($transaction->payee_id, $transaction->amount);
            DB::commit();
            TransactionAuthorizedAndCompleted::dispatch($transaction);
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ErrorOnUpdatingTransactionToAuthorized("Error on updating database");
        }
        return false;
    }

    public function executeRollbackFailedTransaction($transaction_id): bool
    {
        DB::beginTransaction();
        try {
            $transaction = $this->transactionRepository->setNotAuthorized($transaction_id);
            $payee = $this->userRepository->addCredit($transaction->payer_id, $transaction->amount);
            TransactionFailedAndRollbacked::dispatch($transaction);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ErrorOnRollbackTransaction("Error on updating database");
        }
        return false;
    }
}
