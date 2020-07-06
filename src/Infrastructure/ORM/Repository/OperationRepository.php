<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Repository;

use App\Infrastructure\ORM\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    public function add(Operation $operation): Operation
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($operation);
        $entityManager->flush();

        return $operation;
    }

    public function getOperationsByAccount(string $accountUuid): array
    {
        $queryBuilder = $this->createQueryBuilder('o');

        $queryBuilder
            ->join('o.transaction', 't')
            ->join('t.payer', 'pa')
            ->join('t.payee', 'pe')
            ->where('o.account = :uuid')
            ->orderBy('t.createdAt', 'desc')
            ->setParameter('uuid', $accountUuid)
        ;

        return $queryBuilder
            ->getQuery()
            ->execute()
        ;
    }
}
