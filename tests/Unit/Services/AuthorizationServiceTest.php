<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\AuthorizationService;
use Illuminate\Support\Facades\Http;
use Mockery;
use stdClass;

class AuthorizationServiceTest extends TestCase
{
    public function testMustMakeTheExternalEequest()
    {
        $uuid = 'fake';

        $authorizationService = new AuthorizationService();

        Http::shouldReceive('get')->with('https://run.mocky.io/v3/fake')->once();

        $authorizationService->getAuthorization($uuid);
    }

    public function testMustValidateTheAuthorizationServerResponse()
    {
        $fakeHttp = Mockery::mock(stdClass::class);

        $fakeHttp->shouldReceive('json')->andReturn(['message' => 'Autorizado'])->once();
        $fakeHttp->shouldReceive('status')->andReturn(200)->once();

        $uuid = 'fake';

        $authorizationService = new AuthorizationService();

        Http::shouldReceive('get')->with('https://run.mocky.io/v3/fake')->once()
            ->andReturn($fakeHttp);

        $this->assertEquals(true, $authorizationService->isAuthorized($uuid));
    }

    public function testYouShouldNotAuthorizeIfTheStatusCodeIsDifferentFromOK()
    {
        $fakeHttp = Mockery::mock(stdClass::class);

        $fakeHttp->shouldReceive('json')->andReturn(['message' => 'Autorizado'])->once();
        $fakeHttp->shouldReceive('status')->andReturn(400)->once();

        $uuid = 'fake';

        $authorizationService = new AuthorizationService();

        Http::shouldReceive('get')->with('https://run.mocky.io/v3/fake')->once()
            ->andReturn($fakeHttp);

        $this->assertEquals(false, $authorizationService->isAuthorized($uuid));
    }

    public function testeYouShouldNotAuthorizeIfThePayloadIsDifferentThanExpected()
    {
        $fakeHttp = Mockery::mock(stdClass::class);

        $fakeHttp->shouldReceive('json')->andReturn(['message' => 'NotAuthorized'])->once();
        $fakeHttp->shouldReceive('status')->andReturn(400)->once();

        $uuid = 'fake';

        $authorizationService = new AuthorizationService();

        Http::shouldReceive('get')->with('https://run.mocky.io/v3/fake')->once()
            ->andReturn($fakeHttp);

        $this->assertEquals(false, $authorizationService->isAuthorized($uuid));
    }
}
