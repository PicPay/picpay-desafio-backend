<?php

namespace Transfer\Unit\Infra\Http;

use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\RequestInterface;
use Transfer\Infra\Http\Adapter;
use Transfer\Infra\Http\Client;
use Transfer\Stub\GuzzleClientStub;
use Transfer\Stub\ResponseInterfaceStub;
use Transfer\Stub\StreamInterfaceStub;

/**
 * Class AdapterTest
 * @coversDefaultClass \Transfer\Infra\Http\Adapter
 */
class AdapterTest extends \Codeception\Test\Unit
{

    /**
     * @covers ::__construct
     * @covers ::request
     * @covers ::handleResponse
     */
    public function testAdapterSuccessResponse()
    {
        $adapter = $this->buildDefaultAdapter(['message' => 'Autorizado'], 200);
        $adapter->request('https://www.fakeurl.com');
    }

    /**
     * @covers ::__construct
     * @covers ::request
     * @covers ::handleHttpExceptionResponse
     */
    public function testAdapterWhenAnExceptionIsThrown()
    {
        $requestInteface = $this->makeEmpty(RequestInterface::class);
        $exception = new ConnectException('cURL error 28', $requestInteface);
        $adapter = $this->buildExceptiontAdapter($exception);
        $response = $adapter->request('https://www.fakeurl.com');

        $this->assertEquals($response->getReason()[0], 'CONNECTION_TIMEOUT');
    }

    /**
     * @covers ::__construct
     * @covers ::request
     */
    public function testAdapterWhenAGenericExceptionIsThrown()
    {
        $exception = new \Exception('Exceção');
        $adapter = $this->buildExceptiontAdapter($exception);
        $response = $adapter->request('https://www.fakeurl.com');

        $this->assertEquals($response->getReason()[0], 'Exceção');
    }

    /**
     * @param array $responseBody
     * @param $httpCode
     * @return Adapter
     */
    private function buildDefaultAdapter(array $responseBody, $httpCode): Adapter
    {
        $streamInterface = (new StreamInterfaceStub($this))->getDefault(json_encode($responseBody));
        $responseInterface = (new ResponseInterfaceStub($this))->with($streamInterface, $httpCode);
        $httpClient = new Client((new GuzzleClientStub($this))->with($responseInterface));

        $adapter = new Adapter($httpClient);

        return $adapter;
    }

    /**
     * @param $exception
     * @return Adapter
     */
    private function buildExceptiontAdapter($exception): Adapter
    {
        $httpClient = new Client((new GuzzleClientStub($this))->throws($exception));
        $adapter = new Adapter($httpClient);

        return $adapter;
    }
}