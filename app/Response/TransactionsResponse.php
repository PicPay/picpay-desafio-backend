<?php

namespace App\Response;

use Illuminate\Pagination\AbstractPaginator;

class TransactionsResponse extends Response
{
    protected $payload;

    protected $status = 200;

    public function __construct(AbstractPaginator $transactions)
    {
        $transactions->getCollection()->transform(function ($item) {
            return (new TransactionResponse($item))->toArray();
        });

        $this->payload = $transactions->toArray();
    }
}
