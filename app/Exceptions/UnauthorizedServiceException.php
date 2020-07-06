<?php

namespace App\Exceptions;

class UnauthorizedServiceException extends \Exception
{
    public function __construct()
    {
        $this->message = 'This transfer was not authorized';
        $this->code = 401;
    }
}
