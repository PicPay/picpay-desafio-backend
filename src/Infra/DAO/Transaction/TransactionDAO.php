<?php

declare(strict_types=1);

namespace Transfer\Infra\DAO\Transaction;

use Transfer\Domain\Transaction\TransactionDAOInterface;
use Transfer\Domain\Transaction\TransactionDTO;
use Transfer\Infra\DAO\DAOCapabilities;

/**
 * Class TransactionDAO
 * @package Transfer\Infra\DAO\Transaction
 */
class TransactionDAO implements TransactionDAOInterface
{
    private const TRANSACTION_TABLE = 'transaction';

    use DAOCapabilities;

    /**
     * @param TransactionDTO $transactionDTO
     * @return mixed|void
     */
    public function create(TransactionDTO $transactionDTO): void
    {
        $this->database->createQueryBuilder()
            ->insert(static::TRANSACTION_TABLE)
            ->setValue('customer_payer_id', ':customer_payer_id')
            ->setValue('customer_payee_id', ':customer_payee_id')
            ->setValue('value', ':value')
            ->setParameter('customer_payer_id', $transactionDTO->getPayerId())
            ->setParameter('customer_payee_id', $transactionDTO->getPayeeId())
            ->setParameter('value', $transactionDTO->getValue())
            ->execute();
    }
}
