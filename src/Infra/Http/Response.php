<?php

declare(strict_types=1);

namespace Transfer\Infra\Http;

/**
 * Class Response
 * @package Transfer\Infra\Http\Authorization
 */
class Response
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var bool
     */
    private bool $isResponseOk;

    /**
     * @var array|null
     */
    private ?array $reason;

    /**
     * Response constructor.
     * @param int $statusCode
     * @param bool $isResponseOk
     * @param array|null $reason
     */
    public function __construct(int $statusCode, bool $isResponseOk, ?array $reason)
    {
        $this->statusCode = $statusCode;
        $this->isResponseOk = $isResponseOk;
        $this->reason = $reason;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return bool
     */
    public function isResponseOk(): bool
    {
        return $this->isResponseOk;
    }

    /**
     * @return array|null
     */
    public function getReason(): ?array
    {
        return $this->reason;
    }
}
