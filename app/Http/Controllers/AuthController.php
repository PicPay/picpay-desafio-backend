<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Response\LogoutResponse;
use App\Response\ContextResponse;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;
use App\Response\AuthenticateResponse;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        $payload = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $authToken = $this->authService->auth($payload['email'], $payload['password']);

        return (new AuthenticateResponse($authToken))->response();
    }

    public function context(): JsonResponse
    {
        $context = $this->authService->context();

        return (new ContextResponse($context))->response();
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return (new LogoutResponse())->response();
    }

    public function refresh(): JsonResponse
    {
        $authToken = $this->authService->refresh();

        return (new AuthenticateResponse($authToken))->response();
    }
}
