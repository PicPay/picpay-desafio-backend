<?php

namespace App\Response;

class LogoutResponse extends Response
{
    protected $payload;

    protected $status = 200;

    public function __construct()
    {
        $this->payload = ['message' => 'Successfully logged out'];
    }
}
