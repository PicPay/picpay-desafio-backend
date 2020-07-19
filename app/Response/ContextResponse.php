<?php

namespace App\Response;

use App\Models\User;
use App\Response\Response as BaseResponse;

class ContextResponse extends BaseResponse
{
    protected $payload;

    protected $status = 200;

    public function __construct(User $user)
    {
        $this->payload = [
            'fullName' => $user->fullName,
            'email' => $user->email,
            'document' => $user->document,
            'type' => $user->type,
        ];
    }
}
