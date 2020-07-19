<?php

namespace App\Response;

use App\Response\Response as BaseResponse;

class AuthenticateResponse extends BaseResponse
{
    protected $payload;

    protected $status = 201;

    public function __construct(array $authToken)
    {
        $this->payload = [
            'token' => $authToken['token'],
            'type' => $authToken['type'],
            'expirationDate' => $authToken['expirationDate'],
        ];
    }
}
