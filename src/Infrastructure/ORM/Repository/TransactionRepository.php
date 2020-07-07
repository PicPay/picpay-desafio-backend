<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Repository;

use App\Infrastructure\ORM\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransactionRepository extends ServiceEntityRepository implements TransactionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function add(Transaction $transaction): Transaction
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($transaction);
        $entityManager->flush();

        return $transaction;
    }

    public function getList(): array
    {
        return $this->findBy([], ['createdAt' => 'desc']);
    }

    public function get(string $uuid): ?Transaction
    {
        return $this->find($uuid);
    }
}
