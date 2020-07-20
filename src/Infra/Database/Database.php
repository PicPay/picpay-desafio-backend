<?php

declare(strict_types=1);

namespace Transfer\Infra\Database;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Interface Database
 * @package Transfer\Infra
 */
interface Database
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;
    public function close(): void;

    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilder;
}
