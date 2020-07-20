<?php

declare(strict_types=1);

namespace Transfer\Domain;

use Transfer\Infra\Database\Database;

/**
 * Interface DAOInterface
 * @package Transfer\Domain
 */
interface DAOInterface
{
    public function getDatabase(): Database;
}
