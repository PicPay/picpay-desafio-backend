<?php

namespace App\Listeners\Transaction;

use App\Events\TransactionEvent;
use Log;

class ApproveListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TransactionEvent  $event
     * @return void
     */
    public function handle(TransactionEvent $event)
    {

        $event->proceed();
        return $event;
    }
}
