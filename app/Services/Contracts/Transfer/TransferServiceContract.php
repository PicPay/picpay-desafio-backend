<?php

namespace App\Services\Contracts\Transfer;

interface TransferServiceContract
{
    public function registerTransfer($payer_id, $payee_id, $value);

    public function markAsProcessed($transfer_id);
}
