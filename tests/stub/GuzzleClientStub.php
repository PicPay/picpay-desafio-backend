<?php

namespace Transfer\Stub;

use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GuzzleClientStub
 * @package Transfer\Stub
 */
final class GuzzleClientStub
{
    use StubCapabilities;

    /**
     * @param ResponseInterface $response
     * @return MockObject
     */
    public function with(ResponseInterface $response): MockObject
    {
        $requester = $this->createMock(Client::class);
        $requester->method('request')->willReturn($response);
        return $requester;
    }

    /**
     * @param \Exception $exception
     * @return MockObject
     */
    public function throws(\Exception $exception): MockObject
    {
        $requester = $this->createMock(Client::class);
        $requester->method('request')->willThrowException($exception);
        return $requester;
    }

}