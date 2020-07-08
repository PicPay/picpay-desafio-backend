<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Application\Command\AbstractCommand;
use App\Domain\UserAccount\Entity\AccountCollection;
use App\Domain\UserAccount\Service\ListServiceInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class ListCommand extends AbstractCommand
{
    private ListServiceInterface $listService;

    public function __construct(
        ListServiceInterface $listService,
        LoggerInterface $logger
    ) {
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
