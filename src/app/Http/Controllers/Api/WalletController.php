<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Wallet;

class WalletController extends Controller
{
    public function show(Request $request)
    {
        $request->validate([
            'user_id' => 'required | numeric'
        ]);

        $wallet = Wallet::where('user_id', $request->user_id)->pluck('balance')->first();

        if($wallet){
            return response()->json($wallet, 200);
        }

        return response()->json(['message' => 'No Content'], 204);
    }


    public function addFunds(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'value' => 'required'
        ]);

        $currentBalance = Wallet::where('user_id', $request->user_id)->pluck('balance')->first();
        
        Wallet::where('user_id', $request->user_id)->update(['balance' => $currentBalance + $request->value]);

        return response()->json(['message' => 'Ok'], 200);
    }
}
