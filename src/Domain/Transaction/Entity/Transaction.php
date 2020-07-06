<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity;

use App\Domain\Shared\ValueObject\Amount;
use App\Domain\Shared\ValueObject\Uuid\UuidInterface as UuidV4Interface;
use DateTimeInterface;

class Transaction
{
    private UuidV4Interface $uuid;
    private UuidV4Interface $accountPayerUuid;
    private UuidV4Interface $accountPayeeUuid;
    private DateTimeInterface $date;
    private Amount $amount;
    private string $authentication;

    public function getUuid(): UuidV4Interface
    {
        return $this->uuid;
    }

    public function setUuid(UuidV4Interface $uuid): void
    {
        $this->uuid = $uuid;
    }
}
