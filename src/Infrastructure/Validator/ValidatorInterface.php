<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

interface ValidatorInterface
{
    public function hasErrors(): bool;

    public function getErrors(): array;
}
