<?php

namespace Tests\Acceptance\Transactions;

use Mockery;
use stdClass;
use App\Models\User;
use App\Enum\UserType;
use Tests\AcceptanceTestCase;
use App\Events\CreateTransaction;
use Illuminate\Support\Facades\Event;

class CreateTransactionTest extends AcceptanceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $mockBaseResponse = Mockery::mock(stdClass::class);

        $mockBaseResponse->shouldReceive('json')->andReturn(json_encode([]));
        $mockBaseResponse->shouldReceive('status')->andReturn(200);

        $authorizationService = Mockery::mock(AuthorizationService::class);
        $authorizationService->shouldReceive('getAuthorization')->andReturn($mockBaseResponse);

        $this->app->instance(AuthorizationService::class, $authorizationService);
    }

    public function testYouCannotTransferToYourself()
    {
        $user = factory(User::class)->create(['type' => UserType::CUSTUMER]);

        $payload = [
            'value' => 100.00,
            'payer' => $user->id,
            'payee' => $user->id,
        ];

        $response = $this->actingAs($user)->call('POST', 'v1/transaction', $payload);

        $this->assertEquals(400, $response->status());

        $response = json_decode($response->content(), true);

        unset($response['error']['debug']);


        $this->assertEquals(
            [
                'error' => [
                    'code' => 400,
                    'message' => 'It is not possible to transfer from payer to payer.',
                    'errors' => [],
                ],
            ],
            $response
        );
    }

    public function testSellerCannotTransfer()
    {
        $user = factory(User::class)->create(['type' => UserType::CUSTUMER]);
        $userSeller = factory(User::class)->create(['type' => UserType::SELLER]);

        $payload = [
            'value' => 100.00,
            'payer' => $userSeller->id,
            'payee' => $user->id,
        ];

        $response = $this->actingAs($userSeller)->call('POST', 'v1/transaction', $payload);

        $this->assertEquals(400, $response->status());

        $response = json_decode($response->content(), true);

        unset($response['error']['debug']);

        $this->assertEquals(
            [
                'error' => [
                    'code' => 400,
                    'message' => 'Seller user cannot make transfers.',
                    'errors' => [],
                ],
            ],
            $response
        );
    }

    public function testAuthenticatedUserMustBeTheSameUserWhoMakesTheTransfer()
    {
        $user = factory(User::class)->create(['type' => UserType::CUSTUMER]);
        $userPayee = factory(User::class)->create(['type' => UserType::CUSTUMER]);

        $payload = [
            'value' => 100.00,
            'payer' => $userPayee->id,
            'payee' => $user->id,
        ];

        $response = $this->actingAs($user)->call('POST', 'v1/transaction', $payload);

        $this->assertEquals(400, $response->status());

        $response = json_decode($response->content(), true);

        unset($response['error']['debug']);

        $this->assertEquals(
            [
                'error' => [
                    'code' => 400,
                    'message' => 'Invalid payer.',
                    'errors' => [],
                ],
            ],
            $response
        );
    }

    public function testTransactionCreationWithAcceptedAuthorizationEventTriggerCheck()
    {
        Event::fake();

        $user = factory(User::class)->create(['type' => UserType::CUSTUMER]);
        $userPayee = factory(User::class)->create(['type' => UserType::SELLER]);

        $payload = [
            'value' => 100.00,
            'payer' => $user->id,
            'payee' => $userPayee->id,
        ];

        $response = $this->actingAs($user)->call('POST', 'v1/transaction', $payload);

        Event::assertDispatched(CreateTransaction::class, function ($event) use ($user, $userPayee) {
            $transaction = $event->getTransaction();

            return $transaction->payer_id === $user->id && $transaction->payee_id === $userPayee->id;
        });

        $this->assertEquals(201, $response->status());
    }

    public function testTransactionCreationWithAcceptedAuthorization()
    {
        $user = factory(User::class)->create(['type' => UserType::CUSTUMER]);
        $userPayee = factory(User::class)->create(['type' => UserType::SELLER]);

        $payload = [
            'value' => 250.00,
            'payer' => $user->id,
            'payee' => $userPayee->id,
        ];

        $response = $this->actingAs($user)->call('POST', 'v1/transaction', $payload);

        $this->assertEquals(201, $response->status());

        $this->seeInDatabase('transactions', [
            'value' => 250.00,
            'payer_id' => $user->id,
            'payee_id' => $userPayee->id,
        ]);
    }
}
