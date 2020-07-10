<?php

namespace App\Repositories\Contracts\Notification;

interface NotificationRepositoryContract
{
    public function createNotification($transfer_id);
    public function markAsSent($notification_id);
}
