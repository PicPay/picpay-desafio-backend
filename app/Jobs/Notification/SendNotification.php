<?php

namespace App\Jobs\Notification;

use App\Models\Notification\Notification;
use App\Services\Contracts\Notification\NotificationServiceContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class SendNotification
 * @package App\Jobs\Notification
 */
class SendNotification implements ShouldQueue
{
    use Dispatchable;

    /**
     * @var Notification
     */
    private $notification;
    /**
     * @var NotificationServiceContract
     */
    private $notificationService;

    public function __construct(
        Notification $notification,
        NotificationServiceContract $notificationService
    ) {
        $this->notification = $notification;
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->notificationService->sendNotification($this->notification->id)) {
            $this->notificationService->markAsSent($this->notification->id);
        }
    }
}
