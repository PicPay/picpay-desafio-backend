<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Repository;

use App\Infrastructure\ORM\Entity\Operation;

interface OperationRepositoryInterface
{
    public function add(Operation $operation): Operation;

    public function getOperationsByAccount(string $accountUuid): array;
}
