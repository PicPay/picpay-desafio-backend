<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class BaseExceptions extends Exception
{
    public function __construct(string $message, int $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
