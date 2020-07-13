<?php

namespace App\Services\Contracts;

/**
 * Interface AuthorizationResultInterface
 * @package App\Services\Contracts
 */
interface AuthorizationResultInterface
{
    public function isSuccess(): bool;

    public function getMessage(): string;
}
