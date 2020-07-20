<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'payer_wallet_id' => $this->payer_wallet_id,
            'payee_wallet_id' => $this->payee_wallet_id,
            'value'    => $this->value
        ];
    }
}
