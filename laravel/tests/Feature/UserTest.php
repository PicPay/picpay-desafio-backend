<?php

namespace Tests\Feature;

use App\Enums\WalletTypeEnum;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    private const REQUEST_HEADERS = [
        'accept' => 'application/json',
    ];

    private function createUser(): array
    {
        return factory(User::class)->raw([
            "password" => "test123",
            "confirmPassword" => "test123",
            "wallet_type" => WalletTypeEnum::USER_WALLET,
        ]);
    }

    private function createAndSaveUser(): array
    {
        return factory(User::class)->create()->toArray();
    }

    private function createAndSaveUserWithWallet(): array
    {
        $wallet = factory(Wallet::class)->create();
        $user = $wallet->user->toArray();
        return [
            "user" => $user,
            "wallet" => $wallet,
        ];
    }

    private function getReverseWalletType(string $currentType): string
    {
        if ($currentType == WalletTypeEnum::USER_WALLET) {
            return WalletTypeEnum::SHOPKEEPER_WALLET;
        }
        return WalletTypeEnum::USER_WALLET;
    }

    public function testListing()
    {
        $response = $this->get('/api/users', self::REQUEST_HEADERS);
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInsert()
    {
        $user = $this->createUser();
        $response = $this->post('/api/user', $user, self::REQUEST_HEADERS);
        $response->assertStatus(201);
        $this->assertDatabaseHas("users", [
            "email" => $user["email"],
            "identity" => $user["identity"],
        ]);
    }

    public function testFetch()
    {
        $user = $this->createAndSaveUser();
        $response = $this->get('/api/user/' . $user['id'], self::REQUEST_HEADERS);
        $response->assertStatus(200);
        $response->assertJsonFragment(["id" => $user['id']]);
    }

    public function testUpdate()
    {
        $user = $this->createAndSaveUser();
        $user["name"] = "Nome fixo";
        unset($user["password"]);
        $response = $this->put('/api/user/' . $user['id'], $user, self::REQUEST_HEADERS);
        $response->assertStatus(200);
        $this->assertDatabaseHas("users", [
            "id" => $user["id"],
            "name" => $user["name"],
        ]);
    }

    public function testDelete()
    {
        $user = $this->createAndSaveUser();
        $response = $this->delete('/api/user/' . $user['id'], self::REQUEST_HEADERS);
        $response->assertStatus(204);
        $this->assertDatabaseMissing("users", ["id" => $user["id"]]);
    }

    public function testFetchWallet()
    {
        $data = $this->createAndSaveUserWithWallet();
        $response = $this->get('/api/user/' . $data['user']['id'] . '/wallet', self::REQUEST_HEADERS);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $data['wallet']['id'],
            'user_id' => $data['user']['id'],
            'balance' => $data['wallet']['balance'],
        ]);
    }

    public function testForcedUpdateWalletBalance()
    {
        $data = $this->createAndSaveUserWithWallet();
        $newBalance = rand(300, 100000);
        $response = $this->put(
            '/api/user/' . $data['user']['id'] . '/wallet',
            ["balance" => $newBalance],
            self::REQUEST_HEADERS
        );
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $data['wallet']['id'],
            'type' => $data['wallet']['type'],
            'balance' => $newBalance,
        ]);
    }

    public function testForcedUpdateWalletType()
    {
        $data = $this->createAndSaveUserWithWallet();
        $newType = $this->getReverseWalletType($data['wallet']['type']);
        $response = $this->put(
            '/api/user/' . $data['user']['id'] . '/wallet',
            ["type" => $newType],
            self::REQUEST_HEADERS
        );
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $data['wallet']['id'],
            'type' => $newType,
            'balance' => $data['wallet']['balance'],
        ]);
    }

    public function testForcedWalletUpdate()
    {
        $data = $this->createAndSaveUserWithWallet();
        $newBalance = rand(300, 100000);
        $newType = $this->getReverseWalletType($data['wallet']['type']);
        $response = $this->put(
            '/api/user/' . $data['user']['id'] . '/wallet',
            [
                "type" => $newType,
                "balance" => $newBalance,
            ],
            self::REQUEST_HEADERS
        );
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $data['wallet']['id'],
            'type' => $newType,
            'balance' => $newBalance,
        ]);
    }
}
