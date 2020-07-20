<?php

namespace App\Exceptions;

use Exception;

class UserWithNoBalanceException extends Exception
{
    protected $message = 'Usuário não tem saldo para realizar transação';
}