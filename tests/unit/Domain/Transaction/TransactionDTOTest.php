<?php


namespace Transfer\Unit\Transaction;


use Transfer\Domain\Transaction\TransactionDTO;

/**
 * Class TransactionDTOTest
 * @coversDefaultClass \Transfer\Domain\Transaction\TransactionDTO
 */
class TransactionDTOTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::__construct
     * @covers ::getPayerId
     * @covers ::getPayeeId
     * @covers ::getValue
     * @covers ::toArray
     */
    public function testCreateTransactionDto()
    {
        $transactionDto = new TransactionDTO(1, 2, '5');

        $this->assertInstanceOf(TransactionDTO::class, $transactionDto);
        $this->assertEquals(1, $transactionDto->getPayerId());
        $this->assertEquals(2, $transactionDto->getPayeeId());
        $this->assertEquals('5', $transactionDto->getValue());
        $this->assertIsArray($transactionDto->toArray());
    }
}