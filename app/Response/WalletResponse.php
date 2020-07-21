<?php

namespace App\Response;

use App\Models\Wallet;
use App\Response\Response as BaseResponse;

class WalletResponse extends BaseResponse
{
    protected $payload;

    protected $status = 201;

    public function __construct(Wallet $wallet)
    {
        $this->payload = [
            'amount' => $wallet->amount,
            'created_at' => $wallet->created_at,
            'updated_at' => $wallet->updated_at,
        ];
    }
}
