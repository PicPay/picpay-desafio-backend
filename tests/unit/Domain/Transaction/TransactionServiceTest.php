<?php

namespace Transfer\Unit\Transaction;

use Couchbase\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Transfer\Domain\Customer\CustomerBalanceDTO;
use Transfer\Domain\Customer\CustomerDTO;
use Transfer\Domain\Customer\CustomerInterface;
use Transfer\Domain\Customer\CustomerService;
use Transfer\Domain\Transaction\TransactionDTO;
use Transfer\Domain\Transaction\TransactionService;
use Transfer\Infra\Http\TransferAuthorizeAdapter;
use Transfer\Infra\Http\TransferNotificationAdapter;
use Transfer\Infra\QueueAdapter;
use Transfer\Stub\CustomerDaoStub;
use Transfer\Stub\LoggerStub;
use Transfer\Stub\TransactionDAOStub;
use Transfer\Infra\Http\Response;

/**
 * Class TransactionServiceTest
 * @coversDefaultClass \Transfer\Domain\Transaction\TransactionService
 */
class TransactionServiceTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::__construct
     * @covers ::create
     * @covers ::getCustomers
     * @covers ::getCustomerById
     * @covers ::verifyTransfer
     * @covers ::checkPayerFunds
     * @covers ::checkPayeePersonType
     * @covers ::isTransferAuthorized
     * @covers ::updateCustomerBalance
     * @covers ::sendNotification
     */
    public function testCreateSuccessfulTransaction()
    {
        $transactionDao = (new TransactionDAOStub($this))->getDefault();

        $transactionService = new TransactionService(
            $transactionDao,
            $this->getCustomerService(),
            $this->getTransferAuthorizeAdapter($this->getResponseOk()),
            $this->getTransferNotificationAdapter($this->getResponseOk()),
            $this->getQueueAdapter(),
            $this->getLoggerStub()
        );

        $transactionService->create($this->getTransactionDTO("5"));

    }

    /**
     * @covers ::__construct
     * @covers ::create
     * @covers ::getCustomers
     * @covers ::getCustomerById
     * @covers ::verifyTransfer
     * @covers ::checkPayerFunds
     * @covers ::checkPayeePersonType
     * @covers ::isTransferAuthorized
     * @covers ::updateCustomerBalance
     * @covers ::sendNotification
     * @covers ::log
     */
    public function testExceptionWhenCreatingTransaction()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Erro ao salvar transacao no banco de dados');
        $transactionDao = (new TransactionDAOStub($this))->getDefault();
        $transactionDao->method('create')->willThrowException(new \Exception('Erro ao salvar transacao no banco de dados'));

        $transactionService = new TransactionService(
            $transactionDao,
            $this->getCustomerService(),
            $this->getTransferAuthorizeAdapter($this->getResponseOk()),
            $this->getTransferNotificationAdapter($this->getResponseOk()),
            $this->getQueueAdapter(),
            $this->getLoggerStub()
        );

        $transactionService->create($this->getTransactionDTO("5"));
    }

    /**
     * @covers ::__construct
     * @covers ::create
     * @covers ::getCustomers
     * @covers ::getCustomerById
     * @covers ::verifyTransfer
     * @covers ::checkPayerFunds
     * @covers ::checkPayeePersonType
     * @covers ::isTransferAuthorized
     * @covers ::updateCustomerBalance
     * @covers ::sendNotification
     * @covers ::log
     */
    public function testExceptionWhenPayerDoesntHaveEnoughBalance()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('O pagador nao possui saldo suficiente para realizar esta transferencia');

        $transactionDao = (new TransactionDAOStub($this))->getDefault();

        $transactionService = new TransactionService(
            $transactionDao,
            $this->getCustomerService(),
            $this->getTransferAuthorizeAdapter($this->getResponseOk()),
            $this->getTransferNotificationAdapter($this->getResponseOk()),
            $this->getQueueAdapter(),
            $this->getLoggerStub()
        );

        $transactionService->create($this->getTransactionDTO('20'));
    }

    /**
     * @covers ::__construct
     * @covers ::create
     * @covers ::getCustomers
     * @covers ::getCustomerById
     * @covers ::verifyTransfer
     * @covers ::checkPayerFunds
     * @covers ::checkPayeePersonType
     * @covers ::isTransferAuthorized
     * @covers ::updateCustomerBalance
     * @covers ::sendNotification
     * @covers ::log
     */
    public function testExceptionWhenPayerIsPJ()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Apenas contas de pessoa física podem realizar transferencias');

        $transactionDao = (new TransactionDAOStub($this))->getDefault();

        $transactionService = new TransactionService(
            $transactionDao,
            $this->getCustomerService(),
            $this->getTransferAuthorizeAdapter($this->getResponseOk()),
            $this->getTransferNotificationAdapter($this->getResponseOk()),
            $this->getQueueAdapter(),
            $this->getLoggerStub()
        );

        $transactionDto = new TransactionDTO(3, 1, '5');
        $transactionService->create($transactionDto);
    }

    /**
     * @covers ::__construct
     * @covers ::create
     * @covers ::getCustomers
     * @covers ::getCustomerById
     * @covers ::verifyTransfer
     * @covers ::checkPayerFunds
     * @covers ::checkPayeePersonType
     * @covers ::isTransferAuthorized
     * @covers ::updateCustomerBalance
     * @covers ::sendNotification
     * @covers ::log
     */
    public function testExceptionWhenTransferIsNotAuthorized()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('A transferencia nao foi autorizada!');

        $transactionDao = (new TransactionDAOStub($this))->getDefault();

        $transactionService = new TransactionService(
            $transactionDao,
            $this->getCustomerService(),
            $this->getTransferAuthorizeAdapter($this->getResponseNotOk()),
            $this->getTransferNotificationAdapter($this->getResponseOk()),
            $this->getQueueAdapter(),
            $this->getLoggerStub()
        );

        $transactionService->create($this->getTransactionDTO(5));
    }

    /**
     * @covers ::__construct
     * @covers ::create
     * @covers ::getCustomers
     * @covers ::getCustomerById
     * @covers ::verifyTransfer
     * @covers ::checkPayerFunds
     * @covers ::checkPayeePersonType
     * @covers ::isTransferAuthorized
     * @covers ::updateCustomerBalance
     * @covers ::sendNotification
     * @covers ::addRetryMessageToQueue
     */
    public function testWhenNotificationFailedToBeSent()
    {
       $transactionDao = (new TransactionDAOStub($this))->getDefault();

        $transactionService = new TransactionService(
            $transactionDao,
            $this->getCustomerService(),
            $this->getTransferAuthorizeAdapter($this->getResponseOk()),
            $this->getTransferNotificationAdapter($this->getResponseNotOk()),
            $this->getQueueAdapter(),
            $this->getLoggerStub()
        );

        $transactionService->create($this->getTransactionDTO(5));
    }


    /**
     * @return \Codeception\Test\Feature\RealInstanceType|MockObject
     * @throws \Exception
     */
    private function getCustomerService(): MockObject
    {
        $customerService = $this->makeEmpty(CustomerInterface::class);
        $customerService->method('findById')->will(
            $this->returnValueMap(
                [
                    [1, $this->getCustomerBalance(1)],
                    [2, $this->getCustomerBalance(2)],
                    [3, $this->getCustomerBalancePJ(3)]
                ]
            )
        );

        return $customerService;
    }

    /**
     * @param $response
     * @return TransferAuthorizeAdapter
     * @throws \Exception
     */
    private function getTransferAuthorizeAdapter(Response $response): TransferAuthorizeAdapter
    {
        $transferAuthorizeAdapter = $this->makeEmpty(TransferAuthorizeAdapter::class, [
            'request' => static function () use ($response) {
            return $response;
            }
        ]);

        return $transferAuthorizeAdapter;
    }

    /**
     * @param Response $response
     * @return TransferNotificationAdapter
     * @throws \Exception
     */
    private function getTransferNotificationAdapter(Response $response): TransferNotificationAdapter
    {
        $transferNotificationAdapter = $this->makeEmpty(TransferNotificationAdapter::class, [
            'request' => static function () use ($response) {
                return $response;
            }
        ]);

        return $transferNotificationAdapter;
    }

    /**
     * @return \Codeception\Test\Feature\RealInstanceType|\PHPUnit\Framework\MockObject\MockObject
     * @throws \Exception
     */
    private function getQueueAdapter(): MockObject
    {
        return $this->makeEmpty(QueueAdapter::class);
    }

    /**
     * @return MockObject
     */
    private function getLoggerStub(): MockObject
    {
        return (new LoggerStub($this))->getDefault();
    }

    /**
     * @return Response
     */
    private function getResponseOk(): Response
    {
        return new Response(200, true, null);
    }

    /**
     * @return Response
     */
    private function getResponseNotOk(): Response
    {
        return new Response(500, false, []);
    }

    /**
     * @param string $value
     * @return TransactionDTO
     */
    private function getTransactionDTO(string $value): TransactionDTO
    {
        return new TransactionDTO(1, 2, $value);
    }

    /**
     * @param int $id
     * @return CustomerBalanceDTO
     */
    private function getCustomerBalance(int $id)
    {
        return new CustomerBalanceDTO(
            $id,
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
     * @param int $id
     * @return CustomerBalanceDTO
     */
    private function getCustomerBalancePJ(int $id)
    {
        return new CustomerBalanceDTO(
            $id,
            new CustomerDTO(
                'Joao Testador',
                'joao@teste.com',
                'PJ',
                '00940855950',
            ),
            10.30
        );
    }
}