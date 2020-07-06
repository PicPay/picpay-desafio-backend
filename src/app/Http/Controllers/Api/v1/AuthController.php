<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Exceptions\ApiException;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\{
    AuthResource,
    UserResource
};

class AuthController extends Controller
{
    /**
     * @var \App\Services\UserService
     */
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function auth(AuthRequest $request)
    {
        try {
            return new AuthResource($this->service->auth($request));
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function me(Request $request)
    {
        try {
            return new UserResource($request->user());
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(
                [
                    'data' => [
                        'message' => 'Logout realizado com sucesso'
                    ]
                ]
            );
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
