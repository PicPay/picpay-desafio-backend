<?php


namespace Transfer\Stub;

use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\StreamInterface;

/**
 * Class StreamInterfaceStub
 * @package Transfer\Stub
 */
class StreamInterfaceStub
{
    use StubCapabilities;

    /**
     * @param $data
     * @return MockObject
     */
    public function getDefault($data): MockObject
    {
        $streamInterface = $this->createMock(StreamInterface::class);
        $streamInterface->method('getContents')->willReturn($data);
        $streamInterface->method('rewind')->willReturn(null);
        return $streamInterface;
    }

}