<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = [
        'value', 'payer_id', 'payee_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public static function execute($transactionData) {
        $payerId = $transactionData['payer'];
        $value = $transactionData['value'];

        try {
            if (!User::verifyHaveBalance($payerId, $value)) {
                throw new \Exception("The paying user does not have enough balance!");
            }

            DB::beginTransaction();

            $transactionId = self::setTransction($transactionData);
            self::updateWallets($transactionData);

            //throw new \Exception('Testing rollback transaction!');

            DB::commit();

            return $transactionId;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public static function byUser($userId) {
        $transactions = Transaction::where('payer_id', $userId)
            ->orWhere('payee_id', $userId)
            ->with(['payer', 'payee'])
            ->get();

        foreach ($transactions as &$transaction) {
            unset($transaction['payer_id']);
            unset($transaction['payee_id']);
        }

        return $transactions;
    }

    public function payer() {
        return $this->belongsTo('App\User', 'payer_id', 'id')
            ->select(['id', 'fullname']);
    }

    public function payee() {
        return $this->belongsTo('App\User', 'payee_id', 'id')
            ->select(['id', 'fullname']);
    }

    private static function setTransction($transactionData) {
        try {
            $value = $transactionData['value'];
            $transaction = new Transaction([
                "value" => $value,
                "payer_id" => $transactionData['payer'],
                "payee_id" => $transactionData['payee']
            ]);
            $transaction->save();

            return $transaction->id;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    private static function updateWallets($transactionData) {
        try {
            Wallet::updateByTransaction($transactionData);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
