<?php

namespace App\Services\Transfer;

interface TransferServiceInterface
{
    public function executeTransferTransaction($payer_id,$payee_id,$amount);
}
