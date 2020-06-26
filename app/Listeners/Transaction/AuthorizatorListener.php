<?php

namespace App\Listeners\Transaction;

use App\Events\TransactionEvent;
use App\Services\AuthorizatorService;
use Log;

class AuthorizatorListener
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
        $service = new AuthorizatorService();

        $isAuthorized = $service->authorizeTransaction([
            'payer' => $event->getPayer()->id,
            'payee' => $event->getPayee()->id,
            'value' => $event->getTransaction()->value
        ]);

        if( !$isAuthorized ) {
            return $event->abort('Failed to authorize transaction');
        }

        Log::debug('Transaction authorized');

        return $event;
    }
}
