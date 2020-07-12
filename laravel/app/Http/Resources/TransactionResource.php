<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        $payerWallet = $this->payerWallet;
        $payeeWallet = $this->payeeWallet;
        return [
            'id' => $this->id,
            'value' => $this->value,
            'payer' => $payerWallet->user,
            'payer_wallet' => $payerWallet,
            'payer_wallet_id' => $payerWallet->id,
            'payee' => $payeeWallet->user,
            'payee_wallet' => $payeeWallet,
            "payee_wallet_id" => $payeeWallet->id,
        ];
    }
}
