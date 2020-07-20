<?php


namespace Transfer\Stub;


use PHPUnit\Framework\MockObject\MockObject;
use Transfer\Infra\DAO\Transaction\TransactionDAO;

/**
 * Class TransactionDAOStub
 * @package Transfer\Stub
 */
final class TransactionDAOStub
{
    use StubCapabilities;

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    public function getDefault(): MockObject
    {
        return $this->createMock(TransactionDAO::class);
    }

}