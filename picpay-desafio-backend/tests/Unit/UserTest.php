<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    protected $response_structure =
        [
            'id',
            'name',
            'email',
            'type',
            'document'
        ];

    public function testRouteGetAll()
    {
        $response = self::get("/api/users",
            ['accept' => 'application/json', 'content-type' => 'application/json']);

        $response->assertStatus(200);
    }

    public function testRouteGetOne()
    {
        $user = factory('App\Models\User')->create();

        $response = self::get("api/users/" . $user->id,
            ['accept' => 'application/json', 'content-type' => 'application/json']);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->response_structure);
    }

    public function testRouteCreate()
    {
        $user = factory('App\Models\User')->make();
        $this->assertTrue($user->save());
    }

}
