<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Entity;

use function in_array;

class AccountCollection
{
    private array $accounts;

    public function __construct()
    {
        $this->accounts = [];
    }

    public function add(Account $account): bool
    {
        if ($this->has($account)) {
            return false;
        }

        $this->accounts[] = $account;
        return true;
    }

    public function has(Account $account): bool
    {
        return in_array($account, $this->accounts);
    }

    public function remove(Account $account): bool
    {
        if (!$this->has($account)) {
            return false;
        }

        $key = array_search($account, $this->accounts);
        unset($this->accounts[$key]);
        return true;
    }

    public function get(): array
    {
        return $this->accounts;
    }
}
