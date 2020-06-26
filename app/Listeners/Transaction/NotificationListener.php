<?php

namespace App\Listeners\Transaction;

use App\Events\TransactionEvent;
use App\Services\NotificationService;
use Log;

class NotificationListener
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
        $service = new NotificationService();

        $isNotified = $service->notifyTransaction([
            'payer' => $event->getPayer()->id,
            'payee' => $event->getPayee()->id,
            'value' => $event->getTransaction()->value
        ]);

        if( !$isNotified ) {
            return $event->abort('Failed to send transaction notification');
        }

        Log::info("[Debug] Notificated ");
        return $event;
    }
}
