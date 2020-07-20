<?php

namespace App\Services;

use App\Exceptions\UserAuthenticationError;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function auth(string $email, string $password): array
    {
        $token = Auth::attempt(['email' => $email, 'password' => $password]);

        throw_if(! $token, UserAuthenticationError::class);

        return $this->authTokenSanitizer($token);
    }

    public function context(): User
    {
        return Auth::user();
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function refresh(): array
    {
        $newToken = Auth::refresh();

        return $this->authTokenSanitizer($newToken);
    }

    private function authTokenSanitizer($token): array
    {
        return [
            'token' => $token,
            'type' => 'bearer',
            'expirationDate' => Auth::factory()->getTTL() * 60,
        ];
    }
}
