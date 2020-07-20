<?php

namespace App\Response;

use Illuminate\Pagination\LengthAwarePaginator;

class TransactionsResponse extends Response
{
    protected $payload;

    protected $status = 200;

    public function __construct(LengthAwarePaginator $transactions)
    {
        $transactions->getCollection()->transform(function ($item) {
            return (new TransactionResponse($item))->toArray();
        });

        $this->payload = $transactions->toArray();
    }
}
