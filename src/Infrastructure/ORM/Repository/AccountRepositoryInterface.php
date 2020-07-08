<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Repository;

use App\Infrastructure\ORM\Entity\Account;

interface AccountRepositoryInterface
{
    public function add(Account $account): Account;

    public function update(Account $account): Account;

    public function get(string $uuid): ?Account;
}
