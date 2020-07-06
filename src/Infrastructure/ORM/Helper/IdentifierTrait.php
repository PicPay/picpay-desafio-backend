<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Helper;

use Ramsey\Uuid\Uuid;

trait IdentifierTrait
{
    protected string $uuid;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function forgeUuid(): void
    {
        $this->uuid = self::generateUuidV4();
    }

    public static function generateUuidV4(): string
    {
        return Uuid
            ::uuid4()
            ->toString()
        ;
    }
}
