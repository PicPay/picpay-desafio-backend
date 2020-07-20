<?php

namespace Tests\Acceptance\AuthAndRegister;

use App\Enum\UserType;
use App\Models\User;
use Tests\AcceptanceTestCase;

class CreateNewUserTest extends AcceptanceTestCase
{
    public function testMustCreateANewUser()
    {
        $user = factory(User::class)->make();

        $payload = [
            'fullName' => $user->fullName,
            'email' => $user->email,
            'document' => $user->document,
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'type' => $user->type,
        ];

        $response = $this->call('POST', 'v1/register', $payload);

        $this->assertEquals(201, $response->status());

        $this->seeInDatabase('users', [
            'email' => $user->email,
            'document' => $user->document,
        ]);
    }

    public function testMustInformThatTheCpfIsInvalid()
    {
        $user = factory(User::class)->make(['type' => UserType::CUSTUMER]);

        $payload = [
            'fullName' => $user->fullName,
            'email' => $user->email,
            'document' => '41909227825',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'type' => $user->type,
        ];

        $response = $this->call('POST', 'v1/register', $payload);

        $expected = [
            'error' => [
                'code' => 'BadRequestError',
                'message' => 'One or more fields are invalid',
                'errors' => [
                    'document' => [
                        'The document informed is not valid',
                    ],
                ],
            ],
        ];

        $payload = $response->json();

        unset($payload['error']['debug']);

        $this->assertEquals(400, $response->status());
        $this->assertEquals($expected, $payload);
    }

    public function testMustInformThatTheCnpjIsInvalid()
    {
        $user = factory(User::class)->make(['type' => UserType::SELLER]);

        $payload = [
            'fullName' => $user->fullName,
            'email' => $user->email,
            'document' => '12994665001142',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'type' => $user->type,
        ];

        $response = $this->call('POST', 'v1/register', $payload);

        $expected = [
            'error' => [
                'code' => 'BadRequestError',
                'message' => 'One or more fields are invalid',
                'errors' => [
                    'document' => [
                        'The document informed is not valid',
                    ],
                ],
            ],
        ];

        $payload = $response->json();

        unset($payload['error']['debug']);

        $this->assertEquals(400, $response->status());
        $this->assertEquals($expected, $payload);
    }

    public function testMustInformThatTheEmailAndDocumentAlreadyExists()
    {
        $user = factory(User::class)->create();

        $payload = [
            'fullName' => $user->fullName,
            'email' => $user->email,
            'document' => $user->document,
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'type' => $user->type,
        ];

        $response = $this->call('POST', 'v1/register', $payload);

        $expected = [
            'error' => [
                'code' => 'BadRequestError',
                'message' => 'One or more fields are invalid',
                'errors' => [
                    'email' => [
                        0 => 'The email has already been taken.',
                    ],
                    'document' => [
                        0 => 'The document has already been taken.',
                    ],
                ],
            ],
        ];

        $payload = $response->json();

        unset($payload['error']['debug']);

        $this->assertEquals(400, $response->status());
        $this->assertEquals($expected, $payload);
    }
}
