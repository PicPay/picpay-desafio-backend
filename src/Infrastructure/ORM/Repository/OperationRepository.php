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

    public function testBla(string $accountUuid): array
    {
        $queryBuilder = $this->createQueryBuilder('o');

        $queryBuilder
            ->select([
                'o.type AS operation_type',
                't.authentication as transaction_authentication',
                't.amount as transaction_amount',
                't.createdAt as transaction_created_at',
                'pa.uuid as payer_uuid',
            ])
            ->join('o.transaction', 't')
            ->join('t.payer', 'pa')
            ->join('t.payee', 'pe')
            ->where('o.account = :uuid')
            ->setParameter('uuid', 1)
        ;

        return $queryBuilder->getQuery()->execute();
    }
}
