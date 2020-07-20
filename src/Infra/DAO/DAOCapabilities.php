<?php

declare(strict_types=1);

namespace Transfer\Infra\DAO;

use Transfer\Infra\Database\Database;

/**
 * Trait DAOCapabilities
 * @package Transfer\Infra\DAO
 */
trait DAOCapabilities
{
    /**
     * @var Database
     */
    private Database $database;

    /**
     * DAOCapabilities constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return Database
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }
}
