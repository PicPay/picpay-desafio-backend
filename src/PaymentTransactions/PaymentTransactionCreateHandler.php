<?php


namespace App\PaymentTransactions;


use App\Authorizer\TransactionAuthorizer;
use App\Entity\Customer;
use App\Entity\Transaction;
use App\Message\PaymentReceivedMessage;
use App\PaymentTransactions\Exceptions\InsufficientFundsException;
use App\PaymentTransactions\Exceptions\InvalidPayeeException;
use App\PaymentTransactions\Exceptions\InvalidPayerException;
use App\PaymentTransactions\Exceptions\InvalidValueException;
use App\PaymentTransactions\Exceptions\TransactionNotAuthorizedException;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class PaymentTransactionCreateHandler
{
    protected EntityManagerInterface $manager;

    protected CustomerRepository $customerRepository;

    protected TransactionAuthorizer $authorizer;

    protected MessageBusInterface $bus;

    public function __construct(EntityManagerInterface $manager, CustomerRepository $customerRepository, TransactionAuthorizer $authorizer, MessageBusInterface $bus)
    {
        $this->manager = $manager;
        $this->customerRepository = $customerRepository;
        $this->authorizer = $authorizer;
        $this->bus = $bus;
    }

    public function handle(CreateTransactionCommand $command): bool
    {
        $payer = $this->getPayer($command->payer);
        $payee = $this->getPayee($command->payee);

        if ($command->value <= 0) {
            throw new InvalidValueException('The value must be positive');
        }
        if (! $this->authorizer->authorize()) {
            throw new TransactionNotAuthorizedException('Transaction not authorized');
        }

        try {
            $this->manager->beginTransaction();
            $this->debit($payer, $command->value);
            $this->credit($payee, $command->value);

            $transaction = $this->save($payer, $payee, $command->value);

            $this->bus->dispatch(new PaymentReceivedMessage($transaction));

            $this->manager->commit();
        } catch (\Throwable $e) {
            // @TODO Adicionar log
            $this->manager->rollback();
            throw new \RuntimeException($e->getMessage());
        }

        return true;
    }

    private function debit(Customer $payer, $value)
    {
        $wallet = $payer->getWallet();
        $currentValue = $wallet->getValue();

        if ($currentValue < $value) {
            throw new InsufficientFundsException('Insufficient funds');
        }

        $wallet->setValue($currentValue - $value);

        $this->manager->persist($wallet);
        $this->manager->flush();
    }

    private function credit(Customer $payee, $value)
    {
        $wallet = $payee->getWallet();
        $currentValue = $wallet->getValue();

        $wallet->setValue($currentValue + $value);

        $this->manager->persist($wallet);
        $this->manager->flush();
    }

    private function save(Customer $payer, Customer $payee, float $value): Transaction
    {

        $transaction = new Transaction();
        $transaction->setPayee($payee);
        $transaction->setPayer($payer);
        $transaction->setValue($value);

        $this->manager->persist($transaction);
        $this->manager->flush();

        return $transaction;
    }

    private function getPayer(int $payerId): Customer
    {
        $customer = $this->customerRepository->find($payerId);

        if (null == $customer) {
            throw new InvalidPayerException('Invalid payer, payer not found');
        }

        if ($customer->isStore()) {
            throw new InvalidPayerException('Invalid payer, store cannot perform transactions');
        }
        return $customer;
    }

    private function getPayee(int $payerId): Customer
    {
        $customer = $this->customerRepository->find($payerId);

        if (null == $customer) {
            throw new InvalidPayeeException('Invalid payee, payee not found');
        }
        return $customer;
    }
}