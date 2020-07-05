<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserAccountController extends AbstractController
{
    public function handleRegister(Request $request): JsonResponse
    {
        return $this->json(['time' => time(), 'foo' => $request->get('foo')]);
    }
}
