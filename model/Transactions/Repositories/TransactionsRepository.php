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
        DB::beginTransaction();
        try{
            $transaction = $this->model->create([
                'payer_id'                  => $payer_id,
                'payee_id'                  => $payee_id,
                'amount'                    => $amount,
                'authorized'                => false,
                'transaction_status_id'     => 1 // Pending
            ])->fresh(['payer']);

            // Já retira valor da carteira para cálculo de crédito de próximas requisições
            $transaction->payer->credit_balance -= $amount;

            $transaction->push();
            DB::commit();
            return $transaction;

        }catch (QueryException $e){
            DB::rollBack();
        }
    }

    public function setAuthorized($transaction_id) : Transactions
    {
        DB::beginTransaction();
        try{
            $transaction = $this->model
                ->with('payee')
                ->where('transaction_id',$transaction_id)
                ->where('transaction_status_id',1)
                ->first();

            $transaction->authorized = true;
            $transaction->transaction_status_id = 2; // OK

            // Libera valor para a carteira do beneficiário
            $transaction->payee->credit_balance += $transaction->amount;

            $transaction->push();
            DB::commit();

            TransactionAuthorizedAndCompleted::dispatch($transaction);
            return $transaction;

        }catch (QueryException $e){
            DB::rollBack();
        }
    }

    public function setNotAuthorized($transaction_id) : Transactions
    {
        DB::beginTransaction();
        try{
            $transaction = $this->model
                ->with('payee')
                ->where('transaction_id',$transaction_id)
                ->where('transaction_status_id',1)
                ->first();

            $transaction->authorized = false;
            $transaction->transaction_status_id = 3; // Cancelled

            // Devolve valor já retirado a carteira do pagador
            $transaction->payer->credit_balance += $transaction->amount;

            $transaction->push();
            DB::commit();
            return $transaction;

        }catch (QueryException $e){
            DB::rollBack();
        }
    }
}
