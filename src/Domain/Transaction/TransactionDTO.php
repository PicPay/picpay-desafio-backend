<?php

declare(strict_types=1);

namespace Transfer\Domain\Transaction;

/**
 * Class TransactionDTO
 * @package Transfer\Domain\Transaction
 */
class TransactionDTO
{
    /**
     * @var int
     */
    private int $payerId;

    /**
     * @var int
     */
    private int $payeeId;

    /**
     * @var float
     */
    private float $value;

    /**
     * TransactionDTO constructor.
     * @param int $payerId
     * @param int $payeeId
     * @param float $value
     */
    public function __construct(int $payerId, int $payeeId, float $value)
    {
        $this->payerId = $payerId;
        $this->payeeId = $payeeId;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getPayerId(): int
    {
        return $this->payerId;
    }

    /**
     * @return int
     */
    public function getPayeeId(): int
    {
        return $this->payeeId;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'payerId' => $this->getPayerId(),
            'payeeId' => $this->getPayeeId(),
            'value' => $this->getValue()
        ];
    }
}
