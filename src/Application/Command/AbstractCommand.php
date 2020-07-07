<?php

declare(strict_types=1);

namespace App\Application\Command;

use Psr\Log\LoggerInterface;
use Throwable;

abstract class AbstractCommand
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    protected function logException(Throwable $e): void
    {
        $this
            ->logger
            ->error($e->getMessage())
        ;
    }
}
