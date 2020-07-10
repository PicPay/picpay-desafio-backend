<?php

namespace App\Services\Notification;

use App\Repositories\Contracts\Notification\NotificationRepositoryContract;
use App\Services\Contracts\Notification\NotificationServiceContract;
use Illuminate\Support\Facades\Http;

class NotificationService implements NotificationServiceContract
{
    /**
     * @var NotificationRepositoryContract
     */
    private $notificationRepository;

    public function __construct(
        NotificationRepositoryContract $notificationRepository
    ) {
        $this->notificationRepository = $notificationRepository;
    }
    public function createNotification($transfer_id)
    {
        return $this->notificationRepository->createNotification($transfer_id);
    }

    public function markAsSent($notification_id)
    {
        return $this->notificationRepository->markAsSent($notification_id);
    }

    public function sendNotification($notification_id)
    {
        try {
            $result = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
            if (isset($result['message'])) {
                return $result['message']==='Enviado';
            }
            return false;
        }
        catch(\Exception $e){
            return false;
        }
    }
}
