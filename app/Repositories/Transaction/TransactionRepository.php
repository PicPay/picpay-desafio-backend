<?php

namespace App\Repositories\Transaction;

use App\Interfaces\Transaction\TransactionInterface;
use App\Models\Transaction\Transaction;
use App\Events\Transaction\Validation;

class TransactionRepository implements TransactionInterface
{
    protected $model;

    /**
     * Handle __construct
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }

    /**
     * 
     *
     * @param array $payloadData
     * @return array
     */
    public function create(array $payloadData): array
    {
        $transaction = $this->model::create($payloadData);

        $transaction->save();

        event(new Validation($transaction->toArray(), $payloadData));

        return $transaction->toArray();
    }

    /**
     * 
     *
     * @param string $status
     * @param integer $id
     * @return void
     */
    public function updateStatus(string $status, int $id): void
    {
        $this->model
            ->where("id", $id)
            ->update(["status" => $status]);
    }

    /**
     *
     *
     * @param integer $id
     * @return array
     */
    public function findById(int $id): array
    {
        return $this->model::find($id)->toArray();
    }
}