<?php

namespace App\Services;

use App\Exceptions\UserAuthenticationError;
use App\Models\User;

class AuthService
{
    public function auth(string $email, $password): array
    {
        $token = auth()->attempt(['email' => $email, 'password' => $password]);

        throw_if(! $token, UserAuthenticationError::class);

        return $this->authTokenSanitizer($token);
    }

    public function context(): User
    {
        return auth()->user();
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function refresh(): array
    {
        $newToken = auth()->refresh();

        return $this->authTokenSanitizer($newToken);
    }

    private function authTokenSanitizer($token): array
    {
        return [
            'token' => $token,
            'type' => 'bearer',
            'expirationDate' => auth()->factory()->getTTL() * 60,
        ];
    }
}
