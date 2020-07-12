<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'balance' => $this->balance,
            'type' => $this->type,
        ];
    }
}
