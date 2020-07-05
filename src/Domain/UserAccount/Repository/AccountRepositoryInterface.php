<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Repository;

use App\Domain\Shared\ValueObject\DocumentInterface;
use App\Domain\UserAccount\Entity\Account;

interface AccountRepositoryInterface
{
    public function hasByDocument(DocumentInterface $document): bool;

    public function create(Account $account): Account;
}
