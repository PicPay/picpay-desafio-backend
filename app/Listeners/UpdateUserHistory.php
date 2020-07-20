<?php

namespace App\Listeners;

use Log;
use App\Models\UserHistory;
use App\Events\ReceiveTransactions;

class UpdateUserHistory
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
        UserHistory::create([
            'user_id' => $event->transaction()->payer,
            'amount' => -($event->transaction()->value),
            'date' => now()
        ]);

        Log::info('User history inserted', $event->transaction()->toArray());
    }
}
