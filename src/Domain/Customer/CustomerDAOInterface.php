<?php

declare(strict_types=1);

namespace Transfer\Domain\Customer;

use Transfer\Domain\DAOInterface;

/**
 * Interface CustomerDAOInterface
 * @package Transfer\Domain\Customer
 * @codeCoverageIgnore
 */
interface CustomerDAOInterface extends DAOInterface
{
   public function save(CustomerRegisterDTO $customerDTO): void;
   public function findById(int $id): ?CustomerBalanceDTO;
   public function findByDocumentOrEmail(string $email, string $document): ?array;
   public function updateCustomerBalanceById(CustomerBalanceDTO $customerBalanceDTO): void;
}