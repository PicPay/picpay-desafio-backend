<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Helper;

use Ramsey\Uuid\Uuid;

trait IdentifierTrait
{
    protected int $id;
    protected string $uuid;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function forgeUuid(): void
    {
        $this->setUuid(self::generateUuidV4());
    }

    public static function generateUuidV4(): string
    {
        return Uuid
            ::uuid4()
            ->toString()
        ;
    }
}
