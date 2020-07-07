<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use App\Infrastructure\Controller\Api\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TransactionController extends ApiController
{
    public function handleTransaction(Request $request): JsonResponse
    {
        return $this->responseOk(['aa' => 'bb']);
    }
}
