<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Response\TransactionResponse;
use App\Response\TransactionsResponse;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function list(Request $request)
    {
        $status = $request->query('status', ['UNPROCESSED', 'PROCESSED', 'UNAUTHORIZED']);
        $pearPage = $request->query('pearPage', 15);

        $transactionList = $this->transactionService->list($status, $pearPage);

        return (new TransactionsResponse($transactionList))->response();
    }

    public function create(Request $request)
    {
        $payload = $this->validate($request, [
            'value' => 'required|numeric',
            'payer' => 'required|int',
            'payee' => 'required|int',
        ]);

        $this->transactionService->create($payload);

        return response(null, 201);
    }

    public function single(string $id)
    {
        $transaction = $this->transactionService->single($id);

        return (new TransactionResponse($transaction))->response();
    }
}
