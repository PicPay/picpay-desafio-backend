<?php

namespace Transfer\Stub;

use Codeception\PHPUnit\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Trait StubCapabilities
 * @package Transfer\Stub
 */
trait StubCapabilities
{
    /**
     * @var TestCase
     */
    private TestCase $testCase;

    /**
     * StubCapabilities constructor.
     * @param TestCase $testCase
     */
    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * @param $class
     * @return MockObject
     */
    final private function createMock($class): MockObject
    {
        return $this->testCase->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}