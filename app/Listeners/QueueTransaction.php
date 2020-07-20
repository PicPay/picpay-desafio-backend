<?php

namespace App\Listeners;

use App\Events\ReceiveTransactions;
use App\Jobs\ProcessTransaction;

class QueueTransaction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReceiveTransactions  $event
     * @return void
     */
    public function handle(ReceiveTransactions $event)
    {
        ProcessTransaction::dispatch($event->transaction())->onQueue('transactions');
    }
}
