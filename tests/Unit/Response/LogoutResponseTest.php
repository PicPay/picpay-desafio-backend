<?php

namespace Tests\Unit\Response;

use Tests\TestCase;
use App\Models\User;
use App\Response\LogoutResponse;

class LogoutResponseTest extends TestCase
{
    public function testSchemaValidation()
    {
        $user = factory(User::class)->make();

        $logoutResponseTest = new LogoutResponse($user);

        $payload = $logoutResponseTest->response()->getContent();

        $this->assertEquals('{"data":{"message":"Successfully logged out"}}', $payload);
    }
}
