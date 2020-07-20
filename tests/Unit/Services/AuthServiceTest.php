<?php

namespace Tests\Unit\Services;

use App\Models\User;
use Tests\TestCase;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthServiceTest extends TestCase
{
    public function testMustAuthenticateAUser()
    {
        $email = 'foo@mail.com';
        $password = '123456789';

        Auth::shouldReceive('attempt')
            ->with(['email' => $email, 'password' => $password])
            ->once()
            ->andReturn('token-bar');

        Auth::shouldReceive('factory->getTTL')->once()->andReturn(60);

        $expected = [
            'token' => 'token-bar',
            'type' => 'bearer',
            'expirationDate' => 3600,
        ];

        $authService = new AuthService();

        $auth = $authService->auth($email, $password);

        $this->assertEquals($expected, $auth);
    }

    public function testMustReturnTheContext()
    {
        Auth::shouldReceive('logout')->once();

        $authService = new AuthService();

        $this->assertNull($authService->logout());
    }

    public function testMustLogOutTheUser()
    {
        $user = factory(User::class)->make();

        Auth::shouldReceive('user')->once()->andReturn($user);

        $authService = new AuthService();

        $this->assertEquals($user, $authService->context());
    }

    public function testMustRevalidateTheUserToken()
    {
        Auth::shouldReceive('refresh')
            ->once()
            ->andReturn('token-refresh-bar');

        Auth::shouldReceive('factory->getTTL')->once()->andReturn(60);

        $expected = [
            'token' => 'token-refresh-bar',
            'type' => 'bearer',
            'expirationDate' => 3600,
        ];

        $authService = new AuthService();

        $auth = $authService->refresh();

        $this->assertEquals($expected, $auth);
    }
}
