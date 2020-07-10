<?php

namespace App\Services\Authorization;

use App\Services\Contracts\Authorization\AuthorizationServiceContract;
use Illuminate\Support\Facades\Http;

class AuthorizationService implements AuthorizationServiceContract
{
    public function isTransferAuthorized($payer_id, $payee_id, $value)
    {
        try {
            $result = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            if (isset($result['message'])) {
                return $result['message']==='Autorizado';
            }
            return false;
        }
        catch(\Exception $e){
            return false;
        }

    }
}
