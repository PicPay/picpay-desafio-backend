<?php

namespace Transfer\Unit\Domain\Customer;

use Transfer\Domain\Customer\CustomerBalanceDTO;
use Transfer\Domain\Customer\CustomerDTO;
use Transfer\Domain\Customer\CustomerListDTO;
use Transfer\Domain\Customer\CustomerRegisterDTO;
use Transfer\Stub\LoggerStub;
use Transfer\Stub\CustomerDaoStub;
use Transfer\Domain\Customer\CustomerService;

/**
 * Class CustomerServiceTest
 * @coversDefaultClass \Transfer\Domain\Customer\CustomerService
 */
class CustomerServiceTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::__construct
     * @covers ::register
     * @covers ::verifyCustomerRegister
     * @covers ::log
     */
    public function testSuccessRegisterCustomer()
    {
        $customerDao = (new CustomerDaoStub($this))->getDefault();
        $logger = (new LoggerStub($this))->getDefault();

        $customerDao->method('findByDocumentOrEmail')->willReturn(null);

        $customerService = new CustomerService($customerDao, $logger);
        $customerService->register($this->getCustomer());
    }

    /**
     * @covers ::__construct
     * @covers ::register
     * @covers ::verifyCustomerRegister
     * @covers ::log
     */
    public function testWhenCustomerIsAlreadyRegistered()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Usuario ja registrado');

        $customerDao = (new CustomerDaoStub($this))->getDefault();
        $logger = (new LoggerStub($this))->getDefault();

        $customerDao->method('findByDocumentOrEmail')->willReturn(array());

        $customerService = new CustomerService($customerDao, $logger);
        $customerService->register($this->getCustomer());

    }

    /**
     * @covers ::__construct
     * @covers ::register
     * @covers ::verifyCustomerRegister
     * @covers ::log
     */
    public function testWhenDatabaseThrowsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nao foi possivel realizar o cadastro, tente novamente mais tarde!');

        $customerDao = (new CustomerDaoStub($this))->getDefault();
        $logger = (new LoggerStub($this))->getDefault();

        $customerDao->method('save')->willThrowException(new \Exception('Erro ao salvar usuario'));

        $customerService = new CustomerService($customerDao, $logger);
        $customerService->register($this->getCustomer());

    }

    /**
     * @covers ::__construct
     * @covers ::findById
     */
    public function testSucessFindCustomerById()
    {
        $customerDao = (new CustomerDaoStub($this))->getDefault();
        $logger = (new LoggerStub($this))->getDefault();

        $customerDao->method('findById')->willReturn($this->getCustomerBalance());

        $customerService = new CustomerService($customerDao, $logger);
        $customerService->findById(1);
    }

    /**
     * @covers ::__construct
     * @covers ::findById
     */
    public function testWhenCustomerIsNotFoundByIdException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('ID de usuario não encontrado: 1');

        $customerDao = (new CustomerDaoStub($this))->getDefault();
        $logger = (new LoggerStub($this))->getDefault();

        $customerDao->method('findById')->willReturn(null);

        $customerService = new CustomerService($customerDao, $logger);
        $customerService->findById(1);
    }

    /**
     * @covers ::__construct
     * @covers ::updateCustomerBalanceById
     */
    public function testSucessUpdateCustomerBalanceById()
    {
        $customerDao = (new CustomerDaoStub($this))->getDefault();
        $logger = (new LoggerStub($this))->getDefault();

        $customerList = $this->getCustomerList();
        $customerService = new CustomerService($customerDao, $logger);
        $customerService->updateCustomerBalanceById($customerList, 10);
    }

    /**
     * @covers ::__construct
     * @covers ::updateCustomerBalanceById
     */
    public function testFailWhenUpdateCustomerBalanceThrowException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nao foi possivel realizar a transferencia');

        $customerDao = (new CustomerDaoStub($this))->getDefault();
        $customerDao->method('updateCustomerBalanceById')->willThrowException(new \Exception('Erro no banco de dados'));

        $logger = (new LoggerStub($this))->getDefault();

        $customerList = $this->getCustomerList();
        $customerService = new CustomerService($customerDao, $logger);
        $customerService->updateCustomerBalanceById($customerList, 10);

    }


    /**
     * @return CustomerRegisterDTO
     */
    private function getCustomer()
    {
        return new CustomerRegisterDTO(
            'Joao Testador',
            'joao@teste.com',
            'PF',
            '00940855950',
            'myPassWord'
        );
    }

    /**
     * @return CustomerBalanceDTO
     */
    private function getCustomerBalance()
    {
        return new CustomerBalanceDTO(
            1,
            new CustomerDTO(
                'Joao Testador',
                'joao@teste.com',
                'PF',
                '00940855950',
            ),
            10.30
        );
    }

    /**
     * @return CustomerListDTO
     */
    private function getCustomerList()
    {
        $list = new CustomerListDTO();
        $list->add($this->getCustomerBalance(), $list::PAYEE_TYPE);
        $list->add($this->getCustomerBalance(), $list::PAYER_TYPE);

        return $list->getCustomerList();
    }

}