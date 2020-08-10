<?php

namespace App\Services\Transfer;

use Model\Transactions\Transactions;

interface AddTransferServiceInterface
{
    public function executeAddTransfer($payer_id, $payee_id, $amount): Transactions;
}
