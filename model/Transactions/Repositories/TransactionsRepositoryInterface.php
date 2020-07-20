<?php

namespace Model\Transactions\Repositories;

use Model\Transactions\Transactions;

interface TransactionsRepositoryInterface
{
    public function add($payer_id, $payee_id, $amount) : Transactions;
    public function setAuthorized($transaction_id) : Transactions;
    public function setNotAuthorized($transaction_id) : Transactions;
}
