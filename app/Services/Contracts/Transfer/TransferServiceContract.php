<?php

namespace App\Services\Contracts\Transfer;

interface TransferServiceContract
{
    public function processTransfer($payer_id, $payee_id, $value);
}
