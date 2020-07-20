<?php

declare(strict_types=1);

namespace Transfer\Domain\Customer;

/**
 * Class CustomerDTO
 * @package Transfer\Domain\Customer
 */
final class CustomerBalanceDTO
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var CustomerDTO
     */
    private CustomerDTO $customer;

    /**
     * @var float
     */
    private float $balance;

    /**
     * CustomerBalanceDTO constructor.
     * @param int $id
     * @param CustomerDTO $customer
     * @param float $balance
     */
    public function __construct(int $id, CustomerDTO $customer, float $balance)
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->balance = $balance;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return CustomerDTO
     */
    public function getCustomer(): CustomerDTO
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param float $value
     * @return void
     */
    public function addBalance(float $value): void
    {
        $this->balance += $value;
    }

    /**
     * @param float $value
     * @return void
     */
    public function substractValue(float $value): void
    {
        $this->balance -= $value;
    }
}
