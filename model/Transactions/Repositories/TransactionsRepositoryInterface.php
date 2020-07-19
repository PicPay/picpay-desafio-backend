<?php

namespace Model\Transactions\Repositories;

interface TransactionsRepositoryInterface
{
    public function add($payer_id, $payee_id, $amount);
    public function setAuthorized($transfer_id);
    public function setCompleted($transfer_id);
}
