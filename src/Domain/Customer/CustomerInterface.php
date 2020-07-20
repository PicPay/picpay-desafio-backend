<?php

declare(strict_types=1);

namespace Transfer\Domain\Customer;

/**
 * Interface CustomerInterface
 * @package Transfer\Domain\Customer
 */
interface CustomerInterface
{
    public function register(CustomerRegisterDTO $customer): void;
    public function findById(int $id): CustomerBalanceDTO;
    public function updateCustomerBalanceById(array $customerList, float $value): void;
}
