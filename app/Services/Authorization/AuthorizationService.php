<?php

namespace App\Services\Authorization;

use App\Services\Contracts\Authorization\AuthorizationServiceContract;
use Illuminate\Support\Facades\Http;

class AuthorizationService implements AuthorizationServiceContract
{
    /**
     * @var Http
     */
    private $client;

    public function __construct(Http $client)
    {
        $this->client = $client;
    }

    public function isTransferAuthorized($payer_id, $payee_id, $value)
    {
        $result = $this->client::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        if (isset($result['message'])) {
            return $result['message']==='Autorizado';
        }
        return false;
    }
}
