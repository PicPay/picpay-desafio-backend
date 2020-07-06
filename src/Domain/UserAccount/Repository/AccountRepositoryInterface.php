<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Repository;

use App\Domain\Shared\ValueObject\DocumentInterface;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Entity\AccountCollection;

interface AccountRepositoryInterface
{
    public function hasByDocument(DocumentInterface $document): bool;

    public function get(string $accountUuid): ?Account;

    public function create(Account $account): Account;

    public function list(): AccountCollection;
}
