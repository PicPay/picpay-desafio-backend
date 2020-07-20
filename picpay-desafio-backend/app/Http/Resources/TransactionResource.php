<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'payer_id' => $this->payer_id,
            'payee_id' => $this->payee_id,
            'value'    => $this->value
        ];
    }
}
