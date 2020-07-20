<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $response_structure =
        [
            'id',
            'name',
            'email',
            'cpf'
        ];

    public function testUsers()
    {
        $response = self::get("/api/users");

        $response->assertStatus(200);
    }

    public function testRegister()
    {

        $faker = Faker::create();

        $password = $faker->password;
        $data = [
                'name' => $faker->name,
                'email'=> $faker->safeEmail,
                'cpf'=> $faker->numberBetween(10000000000, 99999999999),
                'wallet_type' => $faker->numberBetween(1,2),
                'password' => $password,
                'password_confirmation' => $password
            ];

        $response = self::post("/api/register", $data);
     
        $response->assertStatus(200);

    }

}