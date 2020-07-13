<?php

namespace App\Services\Contracts;

use App\Models\Transfer;

/**
 * Interface AuthorizationServiceInterface
 * @package App\Services\Contracts
 */
interface AuthorizationServiceInterface
{
    public function authorize(Transfer $transfer): AuthorizationResultInterface;
}
