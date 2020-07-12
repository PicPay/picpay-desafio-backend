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
            'payee' => $payeeWallet->user,
            'payee_wallet' => $payeeWallet,
        ];
    }
}
