<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity;

use App\Domain\Shared\ValueObject\Uuid\UuidInterface as UuidV4Interface;

abstract class AbstractAccount
{
    private UuidV4Interface $uuid;

    public function getUuid(): UuidV4Interface
    {
        return $this->uuid;
    }

    public function setUuid(UuidV4Interface $uuid): void
    {
        $this->uuid = $uuid;
    }
}
