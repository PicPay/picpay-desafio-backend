<?php

namespace App\Services\Transfer;

use Model\Transactions\Transactions;

interface FinishTransferServiceInterface
{
    public function executeFinishAuthorizedTransaction($transaction_id): bool;
    public function executeRollbackFailedTransaction($transaction_id): bool;
}
