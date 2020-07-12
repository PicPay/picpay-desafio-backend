<?php

namespace App\Concepts;

use Psr\Http\Message\ResponseInterface;

interface Authorization
{
    public function getAuthorizationResponse(): ResponseInterface;
}
