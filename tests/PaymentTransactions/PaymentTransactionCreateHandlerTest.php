<?php


namespace App\Tests\PaymentTransactions;

use App\Authorizer\TransactionAuthorizer;
use App\Entity\Customer;
use App\Entity\Wallet;
use App\PaymentTransactions\CreateTransactionCommand;
use App\PaymentTransactions\Exceptions\InvalidPayeeException;
use App\PaymentTransactions\Exceptions\InvalidPayerException;
use App\PaymentTransactions\Exceptions\InvalidValueException;
use App\PaymentTransactions\Exceptions\TransactionNotAuthorizedException;
use App\PaymentTransactions\PaymentTransactionCreateHandler;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use \PHPUnit\Framework\TestCase;
use Mockery;

class PaymentTransactionCreateHandlerTest extends TestCase
{
    public function testInvalidPayerNotFound()
    {

        $this->expectException(InvalidPayerException::class);
        $this->expectExceptionMessage('Invalid payer, payer not found');

        $command = new CreateTransactionCommand();
        $command->value = 100;
        $command->payer = 1;
        $command->payee = 2;

        $manager =  Mockery::mock(EntityManagerInterface::class);
        $authorizer = Mockery::mock(TransactionAuthorizer::class);
        $customerRepository = Mockery::mock(CustomerRepository::class);
        $customerRepository->shouldReceive('find')
            ->andReturnNull();

        $handler = new PaymentTransactionCreateHandler($manager, $customerRepository, $authorizer);
        $handler->handle($command);
    }

    public function testInvalidPayerStore()
    {

        $this->expectException(InvalidPayerException::class);
        $this->expectExceptionMessage('Invalid payer, store cannot perform transactions');

        $command = new CreateTransactionCommand();
        $command->value = 100;
        $command->payer = 1;
        $command->payee = 2;

        $customer = (new Customer())
            ->setType(Customer::STORE);

        $manager =  Mockery::mock(EntityManagerInterface::class);
        $authorizer = Mockery::mock(TransactionAuthorizer::class);
        $customerRepository = Mockery::mock(CustomerRepository::class);
        $customerRepository->shouldReceive('find')
            ->andReturn($customer);

        $handler = new PaymentTransactionCreateHandler($manager, $customerRepository,$authorizer);
        $handler->handle($command);
    }

    public function testInvalidPayeeNotFound()
    {

        $this->expectException(InvalidPayeeException::class);
        $this->expectExceptionMessage('Invalid payee, payee not found');

        $command = new CreateTransactionCommand();
        $command->value = 100;
        $command->payer = 1;
        $command->payee = 2;

        $customer = (new Customer())
            ->setType(Customer::COMMON);


        $manager =  Mockery::mock(EntityManagerInterface::class);
        $authorizer = Mockery::mock(TransactionAuthorizer::class);
        $customerRepository = Mockery::mock(CustomerRepository::class);
        $customerRepository->shouldReceive('find')
            ->times(2)
            ->andReturn($customer, null);

        $handler = new PaymentTransactionCreateHandler($manager, $customerRepository, $authorizer);
        $handler->handle($command);
    }

    public function testInvalidValue()
    {

        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('The value must be positive');

        $command = new CreateTransactionCommand();
        $command->value = -100;
        $command->payer = 1;
        $command->payee = 2;

        $customer = (new Customer())
            ->setType(Customer::COMMON);

        $manager =  Mockery::mock(EntityManagerInterface::class);
        $authorizer = Mockery::mock(TransactionAuthorizer::class);
        $customerRepository = Mockery::mock(CustomerRepository::class);
        $customerRepository->shouldReceive('find')
            ->times(2)
            ->andReturn($customer, $customer);

        $handler = new PaymentTransactionCreateHandler($manager, $customerRepository, $authorizer);
        $handler->handle($command);
    }

    public function testNotAuthorized()
    {
        $this->expectException(TransactionNotAuthorizedException::class);
        $this->expectExceptionMessage('Transaction not authorized');

        $command = new CreateTransactionCommand();
        $command->value = 100;
        $command->payer = 1;
        $command->payee = 2;

        $customer = (new Customer())
            ->setType(Customer::COMMON);

        $manager =  Mockery::mock(EntityManagerInterface::class);


        $authorizer = Mockery::mock(TransactionAuthorizer::class);
        $authorizer->shouldReceive('authorize')
            ->andReturnFalse();

        $customerRepository = Mockery::mock(CustomerRepository::class);
        $customerRepository->shouldReceive('find')
            ->times(2)
            ->andReturn($customer, $customer);

        $handler = new PaymentTransactionCreateHandler($manager, $customerRepository, $authorizer);
        $handler->handle($command);
    }

    public function testHandler()
    {

        $command = new CreateTransactionCommand();
        $command->value = 100;
        $command->payer = 1;
        $command->payee = 2;

        $customer = (new Customer())
            ->setType(Customer::COMMON)
            ->setWallet((new Wallet())->setValue(1000.00));

        $customer2 = (new Customer())
            ->setType(Customer::STORE)
            ->setWallet((new Wallet())->setValue(1000.00));

        $manager =  Mockery::mock(EntityManagerInterface::class);
        $manager
        ->shouldReceive('beginTransaction', 'commit', 'rollback', 'persist', 'flush')->andReturns();

        $authorizer = Mockery::mock(TransactionAuthorizer::class);
        $authorizer->shouldReceive('authorize')
            ->andReturnTrue();

        $customerRepository = Mockery::mock(CustomerRepository::class);
        $customerRepository->shouldReceive('find')
            ->times(2)
            ->andReturn($customer, $customer2);

        $handler = new PaymentTransactionCreateHandler($manager, $customerRepository, $authorizer);
        $this->assertTrue($handler->handle($command));
        $this->assertEquals(900, $customer->getWallet()->getValue());
        $this->assertEquals(1100, $customer2->getWallet()->getValue());

    }

}