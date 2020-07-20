<?php

namespace Tests\Unit\Response;

use Tests\TestCase;
use App\Models\User;
use App\Response\ContextResponse;

class ContextResponseTest extends TestCase
{
    public function testSchemaValidation()
    {
        $user = factory(User::class)->make();

        $contextResponse = new ContextResponse($user);

        $payload = $contextResponse->response()->getContent();

        $expected = [
            'data' => [
                'id' => $user->id,
                'fullName' => $user->fullName,
                'email' => $user->email,
                'document' => $user->document,
                'type' => $user->type,
            ],
        ];


        $this->assertEquals(json_encode($expected), $payload);
    }
}
