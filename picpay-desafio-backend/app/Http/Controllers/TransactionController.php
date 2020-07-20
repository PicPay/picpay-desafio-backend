<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Jobs\NotificationJob;
use App\Models\Transaction;
use Throwable;

class TransactionController extends BaseController
{
    public function __construct()
    {
        $this->classModel = Transaction::class;
    }

    public function createTransfer(TransactionRequest $request)
    {
        try {
            $transaction = new Transaction();
            $transaction->makeTransfer($request->all());

            NotificationJob::dispatch($transaction)->onQueue("paymentNotification");

            return response()->json($transaction,201);
        } catch (Throwable $error){
            return response()->json(['message' => $error->getMessage()], 400);
        }
    }
}
