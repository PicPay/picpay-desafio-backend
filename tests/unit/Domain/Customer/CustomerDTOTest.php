<?php

namespace Transfer\Unit\Domain\Customer;

use Transfer\Domain\Customer\CustomerDTO;

/**
 * Class CustomerDtoTest
 * @coversDefaultClass \Transfer\Domain\Customer\CustomerDTO
 */
class CustomerDTOTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getEmail
     * @covers ::getPersonType
     * @covers ::getDocument
     * @covers ::toArray
     */
    public function testBuildSuccessCustomerDto()
    {
        $customerDto = new CustomerDTO(
            'Joao Tester',
            'joao@teste.com',
            'PF',
            '00940855950'
        );

        $this->assertInstanceOf(CustomerDTO::class, $customerDto);
        $this->assertEquals('Joao Tester', $customerDto->getName());
        $this->assertEquals('joao@teste.com', $customerDto->getEmail());
        $this->assertEquals('PF', $customerDto->getPersonType());
        $this->assertEquals('00940855950', $customerDto->getDocument());
        $this->assertIsArray($customerDto->toArray());
    }

}