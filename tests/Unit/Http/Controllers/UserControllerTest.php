<?php
namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase;

     /**
     * @test
    */
    public function receiveValidData(){

        $payload = [
            "name" => "teste",
            "email" => "teste@example.org",
            "document" => "12345678900",
            "type" => "PERSON"
        ];

        $response = $this->postJson('/api/user', $payload);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Usuário criado',
            ]);
    }

    /**
     * @test
    */
    public function receiveExistedEmail(){

        $user = factory(User::class)->create();

        $payload = [
            "name" => "teste",
            "email" => $user->email,
            "document" => "12345678900",
            "type" => "PERSON"
        ];

        $response = $this->postJson('/api/user', $payload);

        $response->assertStatus(400);
    }

    /**
     * @test
    */
    public function receiveExistedDocument(){

        $user = factory(User::class)->create();

        $payload = [
            "name" => "teste",
            "email" => "teste@example.org",
            "document" => $user->document,
            "type" => "PERSON"
        ];

        $response = $this->postJson('/api/user', $payload);

        $response->assertStatus(400);
    }

}