<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationService
{
    const NOTIFICATION_URL = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04';

    const NOTIFICATION_OK_STATUS = 'Enviado';

    private static $instance = null;

    private function __construct(){}

    public function notifyTransactionSuccess( $transactionData ): bool
    {
        $res = Http::post( self::NOTIFICATION_URL, $transactionData );

        $message = $res->json();

        return isset( $message['message'] ) && $message['message'] === self::NOTIFICATION_OK_STATUS;
    }

    public static function getInstance(): NotificationService {

        if (self::$instance == null) {
            self::$instance = new NotificationService();
        }

        return self::$instance;
    }
}
