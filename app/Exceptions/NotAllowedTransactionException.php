<?php

namespace App\Exceptions;

use Exception;

class NotAllowedTransactionException extends Exception
{
    protected $message = "Empresas não podem realizar transações";
}