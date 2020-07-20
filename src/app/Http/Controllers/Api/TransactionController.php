<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Jobs\SendNotification;

use App\Models\Wallet;
use App\Models\Transaction;
use Exception;

class TransactionController extends Controller
{
    public function exchange(Request $request)
    {
        $request->validate([
            "value" => 'required | numeric',
            "payer" => 'required | numeric',
            "payee" => 'required | numeric',
        ]);

        // get customers data
        $payerData = Wallet::find($request->payer);
        $payeeData = Wallet::find($request->payee);

        // validate if customers exists
        if(empty($payerData) || empty($payeeData))
            return response()->json(['message' => 'Wallet not found'], 400);

        // validate if payer is a shopkeeper
        if($payerData->wallet_type == 2)
            return response()->json(['message' => 'Payer is a shopkeeper'], 400);

        // validate if customer have enought funds for transaction
        if($payerData->balance < $request->value)
            return response()->json(['message' => 'Not enough funds for transaction'], 400);

        // authentication
        if(Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6')->failed()){
            return response()->json(['message' => 'Transaction failed'], 500);
        }

        // create transaction
        Transaction::create([
            'payer_id' => $request->payer,
            'payee_id' => $request->payee,
            'value' => $request->value
        ]);

        try {
            // subtract payer's wallet value
            Wallet::where('user_id', $payerData->user_id)->update(['balance' => $payerData->balance - $request->value]);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => 'Transaction failed'], 500);
        }
        
        try {
            // add value to payee's wallet
            Wallet::where('user_id', $payeeData->user_id)->update(['balance' => $payeeData->balance + $request->value]);
            
            // send notification
            try {
                SendNotification::dispatch();
                return response(['message' => 'Ok'], 200);
            } catch (Exception $exception) {
                return response()->json(['message' => 'Unexpected'], 500);      
            }

        } catch (\Illuminate\Database\QueryException $exception) {
            // return spent amount to payer's wallet
            Wallet::where('user_id', $payerData->user_id)->update(['balance' => $payerData->balance]);

            return response()->json(['message' => 'Transaction failed'], 500);
        }
        
    }


    
}
