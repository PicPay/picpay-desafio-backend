<?php
declare(strict_types=1);

namespace Transfer\Unit\Domain\Customer;

use Transfer\Domain\Customer\CustomerRegisterDTO;

/**
 * Class CustomerRegisterDtoTest
 * @coversDefaultClass \Transfer\Domain\Customer\CustomerRegisterDTO
 */
class CustomerRegisterDTOTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getEmail
     * @covers ::getPersonType
     * @covers ::getDocument
     * @covers ::getPassword
     * @covers ::toArray
     */
    public function testBuildSucessCustomerRegisterDto()
    {
        $customerRegisterDto = new CustomerRegisterDTO(
            'Joao Tester',
            'joao@testando.com',
            'PF',
            '00940855950',
            'mypassword'
        );

        $this->assertInstanceOf(CustomerRegisterDTO::class, $customerRegisterDto);
        $this->assertEquals('Joao Tester', $customerRegisterDto->getName());
        $this->assertEquals('joao@testando.com', $customerRegisterDto->getEmail());
        $this->assertEquals('PF', $customerRegisterDto->getPersonType());
        $this->assertEquals('00940855950', $customerRegisterDto->getDocument());
        $this->assertIsString($customerRegisterDto->getPassword());
        $this->assertIsArray($customerRegisterDto->toArray());
    }
}