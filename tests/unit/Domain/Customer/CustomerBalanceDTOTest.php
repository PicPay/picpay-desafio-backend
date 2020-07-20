<?php


namespace Transfer\Unit\Domain\Customer;


use Transfer\Domain\Customer\CustomerBalanceDTO;
use Transfer\Domain\Customer\CustomerDTO;

/**
 * Class CustomerBalanceDTOTest
 * @coversDefaultClass \Transfer\Domain\Customer\CustomerBalanceDTO
 */
class CustomerBalanceDTOTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::__construct
     * @covers ::getCustomer
     * @covers ::getId
     * @covers ::getBalance
     * @covers ::addBalance
     * @covers ::substractValue
     */
    public function testBuildSuccessCustomerBalanceDto()
    {
        $customerDto = new CustomerDTO(
            'Joao Tester',
            'joao@teste.com',
            'PF',
            '00940855950'
        );

        $customerBalanceDto = new CustomerBalanceDTO(
            1,
            $customerDto,
            10.50
        );

        $this->assertInstanceOf(CustomerBalanceDTO::class, $customerBalanceDto);
        $this->assertInstanceOf(CustomerDTO::class, $customerBalanceDto->getCustomer());
        $this->assertEquals(1, $customerBalanceDto->getId());

        $customerBalanceDto->substractValue(1);
        $this->assertEquals(9.50,$customerBalanceDto->getBalance());

        $customerBalanceDto->addBalance(10);
        $this->assertEquals(19.50, $customerBalanceDto->getBalance());
    }

}