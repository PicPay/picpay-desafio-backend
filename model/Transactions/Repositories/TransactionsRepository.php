<?php

namespace Model\Transactions\Repositories;

use App\Events\TransactionAuthorizedAndCompleted;
use Illuminate\Database\QueryException;
use Model\Transactions\Transactions;
use DB;

class TransactionsRepository implements TransactionsRepositoryInterface
{
    private $model;

    public function __construct(Transactions $model)
    {
        $this->model = $model;
    }

    public function add($payer_id, $payee_id, $amount) : Transactions
    {
        return $this->model->create([
            'payer_id'                  => $payer_id,
            'payee_id'                  => $payee_id,
            'amount'                    => $amount,
            'authorized'                => false,
            'transaction_status_id'     => 1 // Pending
        ]);
    }

    public function setAuthorized($transaction_id) : Transactions
    {
        $transaction = $this->model
            ->where('transaction_id',$transaction_id)
            ->where('transaction_status_id',1)
            ->first();
        $transaction->authorized = true;
        $transaction->transaction_status_id = 2; // OK
        $transaction->save();
        return $transaction;
    }

    public function setNotAuthorized($transaction_id) : Transactions
    {
        $transaction = $this->model
            ->with('payee')
            ->where('transaction_id',$transaction_id)
            ->where('transaction_status_id',1)
            ->first();

        $transaction->authorized = false;
        $transaction->transaction_status_id = 3; // Cancelled
        $transaction->save();
        return $transaction;
    }
}
