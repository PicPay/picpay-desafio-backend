<?php

namespace App\Enum;

abstract class TransactionStatus
{
    const UNPROCESSED = 'UNPROCESSED';
    const PROCESSED = 'PROCESSED';
    const UNAUTHORIZED = 'UNAUTHORIZED';
}
