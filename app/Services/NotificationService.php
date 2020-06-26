<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationService
{
    const AUTHORIZATOR_ENDPOINT = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04';
    
    const AUTHORIZED_STATUS     = 'Enviado';

    public function notifyTransaction( $transactionData ): bool
    {
        $res = Http::post( self::AUTHORIZATOR_ENDPOINT, $transactionData );

        $message = $res->json();
        
        return isset( $message['message'] ) && $message['message'] === self::AUTHORIZED_STATUS;
    }
}