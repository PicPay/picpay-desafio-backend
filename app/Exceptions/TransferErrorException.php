<?php

namespace App\Exceptions;

class TransferErrorException extends \Exception
{
    public function __construct()
    {
        $this->message = 'An unexpected error occurred';
        $this->code = 500;
    }
}
