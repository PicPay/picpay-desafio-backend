<?php

namespace App\Exceptions;

use Throwable;

class InvalidPayerException extends BaseExceptions
{
    public function __construct(string $message = 'Invalid payer.', int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
