<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use App\Infrastructure\Controller\Api\ApiController;
use App\Infrastructure\Validator\UserAccountRegisterValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class UserAccountController extends ApiController
{
    public function handleCreate(Request $request): JsonResponse
    {
        $validator = new UserAccountRegisterValidator($request);

        if ($validator->hasErrors()) {
            return $this->responseBadRequest($validator->getErrors());
        }

        try {
            return $this->responseCreated(['time' => time()]);
        } catch (Throwable $e) {
            return $this->responseCreated(['e' => $e->getMessage()]);
        }
    }
}
