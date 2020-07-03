<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizatorService
{
    const AUTHORIZATOR_URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    const AUTHORIZED_OK_STATUS = 'Autorizado';

    private function __construct(){}

    private static $instance = null;

    public function authorize( $transactionData ): bool
    {
        $res = Http::post( self::AUTHORIZATOR_URL, $transactionData );

        $message = $res->json();

        return isset( $message['message'] ) && $message['message'] === self::AUTHORIZED_OK_STATUS;
    }

    public static function getInstance(): AuthorizatorService {

        if (self::$instance == null) {
            self::$instance = new AuthorizatorService();
        }

        return self::$instance;
    }
}
