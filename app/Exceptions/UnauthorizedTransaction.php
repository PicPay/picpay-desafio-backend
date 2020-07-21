<?php

namespace App\Exceptions;

use Throwable;

class UnauthorizedTransaction extends BaseExceptions
{
    public function __construct(string $message = 'Unauthorized transaction.', int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
