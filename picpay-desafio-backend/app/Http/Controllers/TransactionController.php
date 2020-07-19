<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends BaseController
{
    public function __construct()
    {
        $this->classe = Transaction::class;
    }
}
