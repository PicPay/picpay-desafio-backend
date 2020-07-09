<?php

namespace App\Services\Contracts\Authorization;

interface AuthorizationServiceContract
{
    public function isTransferAuthorized($payer_id, $payee_id, $value);
}
