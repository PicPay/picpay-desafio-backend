<?php

namespace App\Services\Authorization\Mocky;

use App\Services\Contracts\AuthorizationResultInterface;

/**
 * Class MockyAuthorizationResult
 * @package App\Services\Authorization\Mocky
 */
class MockyAuthorizationResult implements AuthorizationResultInterface
{
    private const MESSAGE_AUTHORIZED = 'Autorizado';

    /**
     * MockyAuthorizationResult constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->getMessage() === self::MESSAGE_AUTHORIZED;
	}

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->data['message'] ?? '';
    }
}
