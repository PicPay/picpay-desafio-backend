<?php

namespace Transfer\Unit\Infra\Http;

use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Transfer\Infra\Http\Adapter;
use Transfer\Infra\Http\Client;
use Transfer\Stub\GuzzleClientStub;
use Transfer\Stub\ResponseInterfaceStub;
use Transfer\Stub\StreamInterfaceStub;

/**
 * Class ClientTest
 * @coversDefaultClass \Transfer\Infra\Http\Client
 */
class ClientTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::__construct
     * @covers ::request
     */
    public function testClientRequestSuccess()
    {
        $streamInterface = (new StreamInterfaceStub($this))->getDefault(json_encode([]));
        $responseInterface = (new ResponseInterfaceStub($this))->with($streamInterface, 200);
        $httpClient = new Client((new GuzzleClientStub($this))->with($responseInterface));

        $response = $httpClient->request('GET', 'https://www.fakeurl.com');

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @covers ::__construct
     * @covers ::request
     */
    public function testClientRequestException()
    {
        $this->expectException(ConnectException::class);
        $requestInterface = $this->makeEmpty(RequestInterface::class);
        $httpClient = new Client((new GuzzleClientStub($this))->throws(new ConnectException('cURL error 28', $requestInterface)));

        $httpClient->request('GET', 'https://www.fakeurl.com');
    }
}