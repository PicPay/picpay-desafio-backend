<?php

namespace App\Listeners\Notification;

use App\Events\Transfer\TransferAuthorized;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterNotification
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
     * @param  TransferAuthorized  $event
     * @return void
     */
    public function handle(TransferAuthorized $event)
    {
        //
    }
}
