<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Models\Transaction;
use App\Events\ReceiveTransactions;
use App\Http\Requests\Transaction as Request;

class TransactionController extends Controller
{

    private $transaction;

    public function __construct(Transaction $transaction){
        $this->transaction = $transaction;
    }

    public function receive(Request $request){

        Log::info('Received transaction', $request->all());
        try{
            $transaction = $this->transaction->create($request->all());
            event(new ReceiveTransactions($transaction));

        }catch(Exception $e){
            $transaction->status = "FAILED";
            $transaction->save();
            Log::error('Error on validate transaction');
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Transação recebida'], 200);
    }

}
