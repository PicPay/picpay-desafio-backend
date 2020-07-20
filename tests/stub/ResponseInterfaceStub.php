<?php


namespace Transfer\Stub;

use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class ResponseInterfaceStub
 * @package Transfer\Stub
 */
class ResponseInterfaceStub
{
    use StubCapabilities;

    /**
     * @param StreamInterface $body
     * @param $httpCode
     * @return MockObject
     */
    public function with(StreamInterface $body, $httpCode): MockObject
    {
        $responseInterface = $this->createMock(ResponseInterface::class);
        $responseInterface->method('getStatusCode')->willReturn($httpCode);
        $responseInterface->method('getBody')->willReturn($body);

        return $responseInterface;
    }
}