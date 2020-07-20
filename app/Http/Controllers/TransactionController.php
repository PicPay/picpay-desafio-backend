<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
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
}
