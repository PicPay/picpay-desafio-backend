<?php

namespace App\Services\Notification;

use Illuminate\Support\Facades\Http;

class MockyNotificationService
{
    private const MESSAGE_DELIVERED = 'Recebido';

    protected $url;
    protected $data;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function send($message)
    {
//        $this->data = Http::post(env('MOCKY_NOTIFICATION_URL'), $message)->json();
        $this->data = ['message' => 'Recebido'];
    }

    public function isSucess()
    {
        return $this->getMessage() === self::MESSAGE_DELIVERED;
    }

    private function getMessage()
    {
        return $this->data['message'] ?? '';
    }
}
