<?php

namespace Tests\Unit\Response;

use Tests\TestCase;
use App\Response\AuthenticateResponse;

class AuthenticateResponseTest extends TestCase
{
    public function testSchemaValidation()
    {
        $authenticateResponse = new AuthenticateResponse([
            'token' => 'foo-token',
            'type' => 'bearer',
            'expirationDate' => '3600',
        ]);

        $payload = $authenticateResponse->response()->getContent();

        $this->assertEquals('{"data":{"token":"foo-token","type":"bearer","expirationDate":"3600"}}', $payload);
    }
}
