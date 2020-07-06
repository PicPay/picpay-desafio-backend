<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends AbstractController
{
    public function responseOk(array $responseData): JsonResponse
    {
        return $this->json($responseData, Response::HTTP_OK);
    }

    public function responseCreated(array $responseData): JsonResponse
    {
        return $this->json($responseData, Response::HTTP_CREATED);
    }

    public function responseBadRequest(array $responseData): JsonResponse
    {
        return $this->json(['errors' => $responseData], Response::HTTP_BAD_REQUEST);
    }

    public function responseNotFound(array $responseData): JsonResponse
    {
        return $this->json(['errors' => $responseData], Response::HTTP_NOT_FOUND);
    }

    public function responseUnprocessableEntity(array $responseData): JsonResponse
    {
        return $this->json(['errors' => $responseData], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function responseInternalServerError(array $responseData): JsonResponse
    {
        return $this->json(['errors' => $responseData], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
