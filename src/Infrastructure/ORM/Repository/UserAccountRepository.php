<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Repository;

use App\Domain\Entity\UserAccount;
use App\Domain\Repository\UserAccountRepositoryInterface;
use App\Domain\ValueObject\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserAccountRepository extends ServiceEntityRepository implements UserAccountRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAccount::class);
    }

    public function hasByDocument(Document $document): bool
    {
        // TODO: Implement hasByDocument() method.
    }

    public function create(UserAccount $userAccount): UserAccount
    {
        // TODO: Implement create() method.
    }
}
