<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public static function updateByTransaction($transactionData) {
        try {

            $transactionValue = $transactionData['value'];

            $payerWallet = self::find($transactionData['payer']);
            $payerWallet->balance -= $transactionValue;
            $payerWallet->save();

            $payeeWallet = self::find($transactionData['payee']);
            $payeeWallet->balance += $transactionValue;
            $payeeWallet->save();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
