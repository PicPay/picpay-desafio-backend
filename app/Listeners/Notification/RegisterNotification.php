<?php

namespace App\Listeners\Notification;

use App\Events\Transfer\TransferAuthorized;
use App\Jobs\Notification\SendNotification;
use App\Services\Contracts\Notification\NotificationServiceContract;

class RegisterNotification
{
    /**
     * @var NotificationServiceContract
     */
    private $notificationService;

    /**
     * Create the event listener.
     *
     * @param  NotificationServiceContract  $notificationService
     */
    public function __construct(NotificationServiceContract $notificationService)
    {
        $this->notificationService=$notificationService;
    }

    /**
     * Handle the event.
     *
     * @param  TransferAuthorized  $event
     * @return void
     */
    public function handle(TransferAuthorized $event)
    {
        $notification=$this->notificationService->createNotification($event->transfer->id);
        SendNotification::dispatch($notification, $this->notificationService);
    }
}
