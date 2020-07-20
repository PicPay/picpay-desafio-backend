<?php

declare(strict_types=1);

namespace Transfer\Domain\Transaction;

use Transfer\Domain\DAOInterface;

/**
 * Interface TransactionDAOInterface
 * @package Transfer\Domain\Transaction
 */
interface TransactionDAOInterface extends DAOInterface
{
    /**
     * @param TransactionDTO $transactionDTO
     * @return mixed
     */
    public function create(TransactionDTO $transactionDTO): void;
}
