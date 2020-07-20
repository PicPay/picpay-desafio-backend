<?php

namespace App\Exceptions;

use Throwable;

class InsufficientFundsException extends BaseExceptions
{
    public function __construct(string $message = 'There is not enough balance for the operation.', int $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
