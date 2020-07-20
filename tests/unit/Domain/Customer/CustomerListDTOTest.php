<?php


namespace Transfer\Unit\Domain\Customer;


use Transfer\Domain\Customer\CustomerBalanceDTO;
use Transfer\Domain\Customer\CustomerDTO;
use Transfer\Domain\Customer\CustomerListDTO;

/**
 * Class CustomerListDtoTest
 * @coversDefaultClass \Transfer\Domain\Customer\CustomerListDTO
 */
class CustomerListDTOTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::getCustomerList
     * @covers ::add
     */
    public function testBuildSuccessCustomerListDto()
    {
        $customerList = $this->buildCustomerList()->getCustomerList();
        $this->assertIsArray($customerList);
        $this->assertInstanceOf(CustomerBalanceDTO::class, $customerList['payee']);
    }

    /**
     * @return CustomerListDTO
     */
    private function buildCustomerList(): CustomerListDTO
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

        $anotherCustomerBalanceDto = new CustomerBalanceDTO(
            2,
            $customerDto,
            9.90
        );

        $customerList = new CustomerListDTO();
        $customerList->add($customerBalanceDto, $customerList::PAYER_TYPE);
        $customerList->add($anotherCustomerBalanceDto, $customerList::PAYEE_TYPE);

        return $customerList;
    }

}