<?php

namespace App\Observers;

use App\Events\Transfer\TransferAuthorized;
use App\Events\Transfer\TransferCancelled;
use App\Models\Transfer\Transfer;

class TransferObserver
{

    /**
     * @param  Transfer  $transfer
     */
    public function created(Transfer $transfer)
    {
        //
    }

    /**
     * @param  Transfer  $transfer
     */
    public function updated(Transfer $transfer)
    {

    }

    /**
     * @param  Transfer  $transfer
     */
    public function authorized(Transfer $transfer)
    {
       event(new TransferAuthorized($transfer));
    }

    public function cancelled(Transfer $transfer)
    {
        event(new TransferCancelled($transfer));
    }

    /**
     * @param  Transfer  $transfer
     */
    public function deleted(Transfer $transfer)
    {
        //
    }

    /**
     * @param  Transfer  $transfer
     */
    public function restored(Transfer $transfer)
    {
        //
    }

    /**
     * @param  Transfer  $transfer
     */
    public function forceDeleted(Transfer $transfer)
    {
        //
    }
}
