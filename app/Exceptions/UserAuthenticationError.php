<?php

namespace App\Exceptions;

use Throwable;

class UserAuthenticationError extends BaseExceptions
{
    public function __construct(string $message = 'Email or password is wrong.', int $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
