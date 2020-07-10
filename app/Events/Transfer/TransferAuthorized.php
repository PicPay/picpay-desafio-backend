<?php

namespace App\Events\Transfer;

use App\Models\Transfer\Transfer;

class TransferAuthorized
{
    /**
     * @var Transfer
     */
    public $transfer;

    /**
     * Create a new event instance.
     *
     * @param  Transfer  $transfer
     */
    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

}
