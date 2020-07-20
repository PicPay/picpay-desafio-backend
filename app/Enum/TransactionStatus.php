<?php

namespace App\Enum;

abstract class TransactionStatus
{
    const UNPROCESSED = 1;
    const PROCESSED = 2;
    const UNAUTHORIZED = 3;
}
