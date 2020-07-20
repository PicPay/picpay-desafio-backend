<?php

namespace Transfer\Stub;

use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class LoggerStub
 * @package Transfer\Stub
 */
class LoggerStub
{
    use StubCapabilities;

    /**
     * @return MockObject
     */
    public function getDefault(): MockObject
    {
        return $this->createMock(Logger::class);
    }
}