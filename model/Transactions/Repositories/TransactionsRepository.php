<?php

namespace Model\Transactions\Repositories;

use Model\Transactions\Transactions;

class TransactionsRepository implements TransactionsRepositoryInterface
{
    private $model;

    public function __construct(Transactions $model)
    {
        $this->model = $model;
    }

    public function add($payer_id, $payee_id, $amount)
    {
        $transfer = $this->model->create([
            'payer_id'      => $payer_id,
            'payee_id'      => $payee_id,
            'amount'        => $amount,
            'authorized'    => false,
            'completed'     => false
        ])->fresh(['payer','payee']);

        $transfer->payer->credit_balance -= $amount;
        $transfer->payee->credit_balance += $amount;
        $transfer->push();

        return $transfer;
    }
    public function setAuthorized($transaction_id) : Transactions
    {
        $transaction = $this->model->findOrFail($transaction_id);
        $transaction->authorized = true;
        $transaction->save();
        return $transaction;
    }

    public function setCompleted($transaction_id) : Transactions
    {
        $transaction = $this->model->findOrFail($transaction_id);
        $transaction->completed = true;
        $transaction->save();
        return $transaction;
    }
}
