<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Application\Command\AbstractCommand;
use App\Domain\UserAccount\Entity\AccountCollection;
use App\Domain\UserAccount\Service\ListService;
use Psr\Log\LoggerInterface;
use Throwable;

class ListCommand extends AbstractCommand
{
    private ListService $listService;

    public function __construct(ListService $listService, LoggerInterface $logger)
    {
        parent::__construct($logger);
        $this->listService = $listService;
    }

    public function execute(): AccountCollection
    {
        try {
            return $this
                ->listService
                ->handleList()
            ;
        } catch (Throwable $e) {
            $this->logException($e);
            throw $e;
        }
    }
}
