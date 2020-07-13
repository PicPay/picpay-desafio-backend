<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Services\Notification\MockyNotificationService;
use Illuminate\Support\Facades\Log;

class MockyChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     * @return bool
     * @throws \Throwable
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMock($notifiable);

        $mockyClient = new MockyNotificationService(env('MOCKY_NOTIFICATION_URL'));
        $mockyClient->send($message);

        if (!$mockyClient->isSucess()) {
            Log::info("Notification failed: notification $notification->id pushing to failed queue");
            throw new \Exception('Error processing notification');
        }

        return true;
    }
}
