<?php

declare(strict_types=1);

namespace Transfer\Infra\DAO\Customer;

use Transfer\Domain\Customer\CustomerBalanceDTO;
use Transfer\Domain\Customer\CustomerDAOInterface;
use Transfer\Domain\Customer\CustomerDTO;
use Transfer\Domain\Customer\CustomerRegisterDTO;
use Transfer\Infra\DAO\DAOCapabilities;

/**
 * Class CustomerDAO
 * @package Transfer\Infra\DAO\Customer
 */
class CustomerDAO implements CustomerDAOInterface
{
    private const CUSTOMER_TABLE = 'customer';
    private const CUSTOMER_BALANCE_TABLE = 'customer_balance';

    use DAOCapabilities;

    /**
     * @param CustomerRegisterDTO $customerDTO
     */
    public function save(CustomerRegisterDTO $customerDTO): void
    {
        $this->database->createQueryBuilder()
            ->insert(static::CUSTOMER_TABLE)
            ->setValue('name', ':name')
            ->setValue('email', ':email')
            ->setValue('document', ':document')
            ->setValue('type', ':type')
            ->setValue('password', ':password')
            ->setParameter('name', $customerDTO->getName())
            ->setParameter('email', $customerDTO->getEmail())
            ->setParameter('document', $customerDTO->getDocument())
            ->setParameter('type', $customerDTO->getPersonType())
            ->setParameter('password', $customerDTO->getPassword())
            ->execute();
    }

    /**
     * @param int $id
     * @return CustomerBalanceDTO|null
     */
    public function findById(int $id): ?CustomerBalanceDTO
    {
        $query = $this->database->createQueryBuilder()
            ->select(
                'c.id',
                'c.name',
                'c.email',
                'c.document',
                'c.type',
                'cl.balance'
            )
            ->from(static::CUSTOMER_BALANCE_TABLE, 'cl')
            ->join('cl', static::CUSTOMER_TABLE, 'c', 'cl.customer_id = c.id')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->execute();

        $customerResult = $query->fetch();

        if ($customerResult) {
            $customer = new CustomerDTO(
                $customerResult['name'],
                $customerResult['email'],
                $customerResult['type'],
                $customerResult['document']
            );

            return new CustomerBalanceDTO(
                (int)$customerResult['id'],
                $customer,
                (float)$customerResult['balance']
            );
        }

        return null;
    }

    /**
     * @param string $email
     * @param string $document
     * @return |null
     */
    public function findByDocumentOrEmail(string $email, string $document): ?array
    {
        $query = $this->database->createQueryBuilder()
            ->select(
                'c.id',
                'c.name',
                'c.email',
                'c.document',
                'c.type'
            )
            ->from(static::CUSTOMER_TABLE, 'c')
            ->where('c.email = :email')
            ->orWhere('c.document = :document')
            ->setParameter('email', $email)
            ->setParameter('document', $document)
            ->execute();

        $customer = $query->fetch();

        return $customer ? $customer : null;
    }

    /**
     * @param CustomerBalanceDTO $customerBalanceDTO
     */
    public function updateCustomerBalanceById(CustomerBalanceDTO $customerBalanceDTO): void
    {
        $a = $this->database->createQueryBuilder()
            ->update(static::CUSTOMER_BALANCE_TABLE)
            ->set('balance', ':balance')
            ->set('dat_last_modified', ':date')
            ->where('customer_id = :customer_id')
            ->setParameter('balance', $customerBalanceDTO->getBalance())
            ->setParameter('date', date('Y-m-d H:i:s'))
            ->setParameter('customer_id', $customerBalanceDTO->getId())
            ->execute();
    }
}

