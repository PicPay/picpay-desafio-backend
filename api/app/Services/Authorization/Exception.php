<?php

namespace App\Services\Authorization;

use App\Services\Contracts\AuthorizationResultInterface;
use Throwable;

/**
 * Class Exception
 * @package App\Services\Authorization
 */
final class Exception implements AuthorizationResultInterface
{
    /** @var Throwable */
    private $e;

    public function __construct(Throwable $e)
    {
        $this->e = $e;
    }

    /**
     * @return bool
     */
    public final function isSuccess(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public final function getMessage(): string
    {
        return $this->e->getMessage();
    }
}
