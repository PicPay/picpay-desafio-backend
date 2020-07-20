<?php

namespace Transfer\Infra\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Runner\Exception;

/**
 * Class DatabaseAdapter
 * @package Transfer\Infra
 */
class DatabaseAdapter implements Database
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DatabaseAdapter constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function commit(): void
    {
        try {
            $this->connection->commit();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function rollBack(): void
    {
        try {
            $this->connection->rollBack();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }

    public function close(): void
    {
        $this->connection->close();
    }
}
