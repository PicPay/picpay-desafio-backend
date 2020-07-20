<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;
    protected $response_structure =
        [
            'id',
            'user_id',
            'balance',
        ];

    public function testRouteGetAll()
    {
        $response = self::get("/api/wallets",
            ['accept' => 'application/json', 'content-type' => 'application/json']);

        $response->assertStatus(200);
    }

    public function testRouteGetOne()
    {
        $user = factory('App\Models\Wallet')->create();

        $response = self::get("api/wallets/" . $user->id,
            ['accept' => 'application/json', 'content-type' => 'application/json']);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->response_structure);
    }

    public function testCantCreateWallet()
    {
        $wallet = factory('App\Models\Wallet')->make();
        $response = $this->post("api/wallets", $wallet->toArray(),
           ['accept' => 'application/json', 'content-type' => 'application/json']);
        $response->assertStatus(405, "Metodo não permitido");
    }

}
