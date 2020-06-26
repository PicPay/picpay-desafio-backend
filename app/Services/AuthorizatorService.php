<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizatorService
{
    const AUTHORIZATOR_ENDPOINT = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
    
    const AUTHORIZED_STATUS     = 'Autorizado';

    public function authorizeTransaction( $transactionData ): bool
    {
        $res = Http::post( self::AUTHORIZATOR_ENDPOINT, $transactionData );

        $message = $res->json();
        
        return isset( $message['message'] ) && $message['message'] === self::AUTHORIZED_STATUS;
    }
}