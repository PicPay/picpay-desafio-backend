<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'identity_type' => $this->identity_type,
            'identity' => $this->identity,
            'status' => $this->status,
            'wallet' => $this->wallet,
        ];
    }
}
