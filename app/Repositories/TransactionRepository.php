<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Transaction::class;
    }
}
