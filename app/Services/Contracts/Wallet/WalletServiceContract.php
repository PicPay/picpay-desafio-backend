<?php

namespace App\Services\Contracts\Wallet;

interface WalletServiceContract
{
    public function applyTransfer($payer_id, $payee_id, $value);
    public function revertTransfer($payer_id, $payee_id, $value);
    public function isReversible($transfer);
}
