<?php


namespace Transfer\Unit\Infra\Http;

use Transfer\Infra\Http\Response;

/**
 * Class ResponseTest
 * @coversDefaultClass \Transfer\Infra\Http\Response
 */
class ResponseTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::__construct
     * @covers ::getStatusCode
     * @covers ::isResponseOk
     * @covers ::getReason
     */
    public function testCreateResponseOk()
    {
        $response = new Response(200, true, null);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $response->isResponseOk());
        $this->assertNull($response->getReason());
    }
}
