<?php

namespace App\Response;

use App\Models\Transaction;

class TransactionResponse extends Response
{
    protected $payload;

    protected $status = 200;

    public function __construct(Transaction $transaction)
    {
        $this->payload = [
            'id' => $transaction->id,
            'value' => (float) $transaction->value,
            'status' => $transaction->status,
            'created_at' => $transaction->created_at,
            'updated_at' => $transaction->updated_at,
        ];
    }
}
