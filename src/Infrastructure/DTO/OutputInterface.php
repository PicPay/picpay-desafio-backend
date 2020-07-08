<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO;

interface OutputInterface
{
    public function toArray(): array;
}
