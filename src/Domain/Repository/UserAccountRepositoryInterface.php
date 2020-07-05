<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\UserAccount;
use App\Domain\ValueObject\Document;

interface UserAccountRepositoryInterface
{
    public function hasByDocument(Document $document): bool;

    public function create(UserAccount $userAccount): UserAccount;
}
