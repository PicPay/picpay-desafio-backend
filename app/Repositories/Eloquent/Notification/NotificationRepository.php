<?php

namespace App\Repositories\Eloquent\Notification;

use App\Models\Notification\Notification;
use App\Repositories\Contracts\Notification\NotificationRepositoryContract;

class NotificationRepository implements NotificationRepositoryContract
{
    /**
     * @var Notification
     */
    private $model;

    public function __construct()
    {
        $this->model = new Notification;
    }

    public function createNotification($transfer_id)
    {
        return $this->model->create(
            [
                'transfer_id' => $transfer_id
            ]
        );
    }

    public function markAsSent($notification_id)
    {
        $notification = $this->model->find($notification_id);
        if ($notification) {
            $notification->status = 1;
            $notification->save();
            return $notification;
        }
        return false;
    }
}
