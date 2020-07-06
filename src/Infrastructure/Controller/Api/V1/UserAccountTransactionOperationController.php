<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use App\Domain\UserAccount\Exception\Service\GetService\AccountNotFoundException;
use App\Infrastructure\Controller\Api\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class UserAccountTransactionOperationController extends ApiController
{
    public function handleList(string $uuid): JsonResponse
    {
        try {
            return $this->responseOk(['uuid' => $uuid]);
        } catch (AccountNotFoundException $e) {
            return $this->responseNotFound([$e->getMessage()]);
        } catch (Throwable $e) {
            return $this->responseInternalServerError([$e->getMessage()]);
        }
    }
}
