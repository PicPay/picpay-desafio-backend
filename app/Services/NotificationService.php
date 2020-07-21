<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function send(array $message)
    {
        $url = config('app.url_notification');

        $response = Http::post($url, $message);

        return $response;
    }

    public function sendNotification(User $user, string $message): void
    {
        $payload = ['user_id' => $user->id, 'message' => $message];

        Log::info('flush_notification', $payload);

        $this->send($payload);
    }
}
