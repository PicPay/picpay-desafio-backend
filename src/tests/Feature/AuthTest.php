<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @testdox Autenticação.
     * @group @feature-auth
     * @test
     */
    public function testAuth()
    {
        $user = factory(User::class)->create();

        $payload = [
            'email' => $user->email,
            'password' => $user->password,
        ];

        $response = $this->postJson('/api/auth/token', $payload);

        $response->assertStatus(200)
                    ->assertJsonStructure(['token']);
    }
}