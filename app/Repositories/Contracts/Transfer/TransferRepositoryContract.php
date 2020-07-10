<?php

namespace App\Repositories\Contracts\Transfer;

interface TransferRepositoryContract
{
    public function createTransfer($payer_id, $payee_id, $value);
    public function setTransferAsAuthorized($transfer_id);
    public function markAsProcessed($transfer_id);
}
