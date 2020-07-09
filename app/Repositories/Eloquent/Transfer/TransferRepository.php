<?php

namespace App\Repositories\Eloquent\Transfer;

use App\Models\Transfer\Transfer;
use App\Repositories\Contracts\Transfer\TransferRepositoryContract;

class TransferRepository implements TransferRepositoryContract
{
    public function __construct()
    {
        $this->model = new Transfer;
    }

    public function createTransfer($payer_id, $payee_id, $value)
    {
        return $this->model->create(
            [
                'payer_id' => $payer_id,
                'payee_id' => $payee_id,
                'value' => $value,
            ]
        );
    }

    public function setTransferAsAuthorized($transfer_id)
    {
        $transfer = $this->model->find($transfer_id);
        if($transfer)
        {
            $transfer->authorization_status=1;
            $transfer->save();
            return $transfer;
        }
        return false;
    }
}
