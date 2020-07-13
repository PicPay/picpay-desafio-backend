<?php

namespace App\Services\Notification\Mocky;

use App\Services\Contracts\AuthorizationResultInterface;

/**
 * Class MockyAuthorizationResult
 * @package App\Services\Authorization\Mocky
 */
class MockyNotificationResult implements AuthorizationResultInterface
{
    private const MESSAGE_DELIVERED = 'Recebido';

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
        return $this->getMessage() === self::MESSAGE_DELIVERED;
	}

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->data['message'] ?? '';
    }
}
