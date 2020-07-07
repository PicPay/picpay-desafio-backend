<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transaction;

use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\UuidInterface as UuidV4Interface;

final class Account
{
    private UuidV4Interface $uuid;
    private Document $document;

    public function getUuid(): UuidV4Interface
    {
        return $this->uuid;
    }

    public function setUuid(UuidV4Interface $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setDocument(Document $document): void
    {
        $this->document = $document;
    }
}
