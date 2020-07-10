<?php

namespace App\Services\Contracts\Notification;

interface NotificationServiceContract
{
    public function createNotification($transfer_id);
    public function markAsSent($notification_id);
    public function sendNotification($notification_id);
}
