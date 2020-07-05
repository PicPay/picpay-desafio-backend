<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends AbstractController
{
    public function responseBadRequest(array $responseData): JsonResponse
    {
        return $this->json($responseData, Response::HTTP_BAD_REQUEST);
    }

    public function responseCreated(array $responseData): JsonResponse
    {
        return $this->json($responseData, Response::HTTP_CREATED);
    }
}
