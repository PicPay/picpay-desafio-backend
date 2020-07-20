<?php

namespace App\Models;

use App\Exceptions\InvalidTransactionException;
use App\Exceptions\NotEnoughBalanceException;
use App\Exceptions\UnauthorizedException;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = ['payer_wallet_id', 'payee_wallet_id', 'value'];

    public function wallet()
    {
        return $this->belongsTo('App\Models\Wallet');
    }

    public function makeTransfer(array $transfer)
    {
        if (!$this->isAuthorized()) {
            throw new UnauthorizedException('Transação não autorizada');
        }
        DB::transaction(function () use ($transfer) {
            $payer = User::findOrFail($transfer['payer_wallet_id']);
            $payee = User::findOrFail($transfer['payee_wallet_id']);
            $value = floatval($transfer['value']);

            $payerWallet = Wallet::where('user_id', '=', $payer->id)->firstOrFail();
            $payeeWallet = Wallet::where('user_id', '=', $payee->id)->firstOrFail();

            if ($this->isSame($payer->id, $payee->id)) {
                throw new InvalidTransactionException("ID do pagador não pode ser igual ao do receptor.");
            }
            if (!$payerWallet->hasBalance($value)) {
                throw new NotEnoughBalanceException("Saldo insuficiente.");
            }
            if ($payer->isSalesPerson()){
                throw new InvalidTransactionException("Lojista não tem permissão para fazer transferências");
            }
            $payerWallet->debitBalance($value);
            $payerWallet->saveOrFail();

            $payeeWallet->addBalance($value);
            $payeeWallet->saveOrFail();

            $this->value = $value;
            $this->payer_wallet_id = $payerWallet->id;
            $this->payee_wallet_id = $payeeWallet->id;
            $this->saveOrFail();

            return true;
        });
    }

    public function isSame(int $payer, int $payee)
    {
        return $payer == $payee;
    }

    public function isAuthorized(): bool
    {
        $client = new Client();
        try {
            $response = $client->get("https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6");
            return $response->getStatusCode() === 200;
        } catch (\Throwable $error) {
            return false;
        }
    }
}
