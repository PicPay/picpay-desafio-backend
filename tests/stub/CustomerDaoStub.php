<?php

namespace Transfer\Stub;

use PHPUnit\Framework\MockObject\MockObject;
use Transfer\Infra\DAO\Customer\CustomerDAO;

/**
 * Class CustomerDaoStub
 * @package Transfer\Stub
 */
final class CustomerDaoStub
{
    use StubCapabilities;

    /**
     * @return MockObject
     */
    public function getDefault(): MockObject
    {
        return $this->createMock(CustomerDAO::class);
    }
}
