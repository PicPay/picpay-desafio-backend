<?php

namespace App\Services\Authorization;

use App\Models\Transfer;
use App\Services\Authorization\Mocky\MockyAuthorizationResult;
use App\Services\Contracts\AuthorizationResultInterface;
use App\Services\Contracts\AuthorizationServiceInterface;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Class MockyAuthorizationService
 * @package App\Services\Authorization
 */
class MockyAuthorizationService implements AuthorizationServiceInterface
{
    /**
     * MockyAuthorizationService constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @param Transfer $transfer
     * @return AuthorizationResultInterface
     */
    public function authorize(Transfer $transfer): AuthorizationResultInterface
    {
        try {
            return new MockyAuthorizationResult(Http::get($this->url)->json());
		} catch(Throwable $e) {
            return new Exception($e);
        }
    }
}
