<?php

namespace Tests\Acceptance\AuthAndRegister;

use App\Models\User;
use App\Models\Wallet;
use Tests\AcceptanceTestCase;

class AuthUserTest extends AcceptanceTestCase
{
    public function testMustReturnTheUserContext()
    {
        $user = factory(User::class)->create(['wallet_id' => factory(Wallet::class)->create()->id]);

        $response = $this->actingAs($user)->call('GET', 'v1/accounts/context');

        $payload = $response->json();

        $expected = [
            'data' => [
                'id' => $user->id,
                'fullName' => $user->fullName,
                'email' => $user->email,
                'document' => $user->document,
                'type' => $user->type,
            ],
        ];

        $this->assertEquals(200, $response->status());
        $this->assertEquals($expected, $payload);
    }

    public function testMustDisqualifyAUser()
    {
        $user = factory(User::class)->create(['wallet_id' => factory(Wallet::class)->create()->id]);

        $response = $this->actingAs($user)->call('POST', 'v1/accounts/logout');

        $this->assertEquals(500, $response->status());
    }

    public function testMustUpdateAUserToken()
    {
        $user = factory(User::class)->create(['wallet_id' => factory(Wallet::class)->create()->id]);

        $response = $this->actingAs($user)->call('POST', 'v1/accounts/refresh');

        $this->assertEquals(500, $response->status());
    }
}
