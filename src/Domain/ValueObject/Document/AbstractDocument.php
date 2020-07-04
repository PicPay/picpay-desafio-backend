<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Document;

abstract class AbstractDocument implements DocumentInterface
{
    protected string $number;

    public function getNumber(): string
    {
        return $this->number;
    }
}
