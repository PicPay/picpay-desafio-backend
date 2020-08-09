<?php

namespace App\Services\Authorization;

interface CheckAuthorizationServiceInterface
{
    public function executeCheckAuthorization($transaction_id) : bool ;
}
