<?php

declare(strict_types=1);

namespace Transfer\Domain\Customer;

/**
 * Class CustomerListDTO
 * @package Transfer\Domain\Customer
 */
class CustomerListDTO
{
    public const PAYER_TYPE = 'payer';
    public const PAYEE_TYPE = 'payee';
    /**
     * @var array
     */
    private array $customers;

    /**
     * @return array
     */
    public function getCustomerList(): array
    {
        return $this->customers;
    }

    /**
     * @param CustomerBalanceDTO $customerBalanceDTO
     * @param $type
     */
    public function add(CustomerBalanceDTO $customerBalanceDTO, string $type): void
    {
        $this->customers[$type] = $customerBalanceDTO;
    }
}

