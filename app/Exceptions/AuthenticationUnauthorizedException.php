<?php

namespace App\Exceptions;

use Throwable;

class AuthenticationUnauthorizedException extends BaseExceptions
{
    public function __construct(string $message = 'Unauthorized.', int $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
