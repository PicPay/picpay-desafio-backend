<?php

declare(strict_types=1);

namespace Transfer\Domain\Customer;

use Psr\Log\LoggerInterface;

/**
 * Class CustomerService
 * @package Transfer\Domain\Customer
 */
final class CustomerService implements CustomerInterface
{
    /**
     * @var CustomerDAOInterface
     */
    private CustomerDAOInterface $customerDAO;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * CustomerService constructor.
     * @param CustomerDAOInterface $customerDAO
     * @param LoggerInterface $logger
     */
    public function __construct(CustomerDAOInterface $customerDAO, LoggerInterface $logger)
    {
        $this->customerDAO = $customerDAO;
        $this->logger = $logger;
    }

    /**
     * @param CustomerRegisterDTO $customer
     * @return string
     * @throws \Exception
     */
    public function register(CustomerRegisterDTO $customer): void
    {
        if ($this->verifyCustomerRegister($customer)) {

            $log = [
                'data' => [
                    'customer' => $customer->toArray()
                ],
                'key' => 'register_customer',
                'message' => 'Ja existe um usuario cadastrado com os dados informados.',
                'class' => __CLASS__,
                'method' => __METHOD__
            ];

            $this->log($log);

            throw new \Exception('Usuario ja registrado');
        }

        $this->customerDAO->getDatabase()->beginTransaction();

        try {
            $this->customerDAO->save($customer);
            $this->customerDAO->getDatabase()->commit();
        } catch (\Exception $exception) {
            $log = [
                'data' => [
                    'customer' => $customer->toArray()
                ],
                'key' => 'register_customer_error',
                'message' => 'Erro ao inserir registro no banco de dados',
                'class' => __CLASS__,
                'method' => __METHOD__
            ];
            $this->log($log);
            $this->customerDAO->getDatabase()->rollBack();
            throw new \Exception('Nao foi possivel realizar o cadastro, tente novamente mais tarde!');
        }
    }

     /**
     * @param CustomerRegisterDTO $customer
     * @return bool
     */
    private function verifyCustomerRegister(CustomerRegisterDTO $customer): bool
    {
        return is_array($this->customerDAO->findByDocumentOrEmail($customer->getEmail(), $customer->getDocument()));
    }

    /**
     * @param int $id
     * @return CustomerBalanceDTO
     * @throws \Exception
     */
    public function findById(int $id): CustomerBalanceDTO
    {
        $customer = $this->customerDAO->findById($id);
        if (!is_a($customer, CustomerBalanceDTO::class)) {
            $log = [
                'data' => [
                    'customerId' => $id
                ],
                'key' => 'customer_not_found',
                'message' => 'Não foi possivel encontrar um usuario para o id informado',
                'class' => __CLASS__,
                'method' => __METHOD__
            ];
            $this->log($log);
            throw new \Exception('ID de usuario não encontrado: ' . $id);
        }

        return $customer;
    }

    /**
     * @param array $customerList
     * @param float $value
     * @throws \Exception
     */
    public function updateCustomerBalanceById(array $customerList, float $value): void
    {
        foreach ($customerList as $key => $customer) {

            try{
                $this->customerDAO->getDatabase()->beginTransaction();

                if ($key === 'payer') {
                    $customer->substractValue($value);
                    $this->customerDAO->updateCustomerBalanceById($customer);
                    $this->customerDAO->getDatabase()->commit();
                    continue;
                }

                $customer->addBalance($value);

                $this->customerDAO->updateCustomerBalanceById($customer);
                $this->customerDAO->getDatabase()->commit();
            } catch (\Exception $e) {
                $log = [
                    'data' => [
                        'customer' => $customer->getCustomer()->toArray()
                    ],
                    'key' => 'customer_update_balance_error',
                    'message' => 'Não foi possivel atualizar o saldo do cliente',
                    'class' => __CLASS__,
                    'method' => __METHOD__
                ];
                $this->log($log);
                $this->customerDAO->getDatabase()->rollBack();
                throw new \Exception('Nao foi possivel realizar a transferencia');
            }

        }
    }

    /**
     * @param array $data
     * @param string $type
     */
    private function log(array $data, string $type = 'INFO'): void
    {
        $this->logger->log($type, json_encode($data));
    }
}
