<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\Wallet;

class WalletTest extends TestCase
{
    use RefreshDatabase;
    protected $response_structure =
        [
            'id',
            'user_id',
            'balance',
        ];

    public function testAddfunds()
    {

        $user = factory(User::class)->create();
        factory(Wallet::class)->create(['user_id' => $user->id]);

        $faker = Faker::create();

        $data =[
            'user_id' => $user->id,
            'value' => $faker->randomNumber(),
        ];

        $response = self::post("/api/addfunds", $data);

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $user = factory(User::class)->create();
        factory(Wallet::class)->create(['user_id' => $user->id]);

        $response = self::post("api/wallet", ['user_id' => $user->id]);
        $response->assertStatus(200);

    }

}
