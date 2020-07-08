<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Application\Command\AbstractCommand;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Service\GetServiceInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class GetCommand extends AbstractCommand
{
    private GetServiceInterface $getService;

    public function __construct(
        GetServiceInterface $getService,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
        $this->getService = $getService;
    }

    public function execute(string $accountUuid): Account
    {
        try {
            return $this
                ->getService
                ->handleGet($accountUuid)
            ;
        } catch (Throwable $e) {
            $this->logException($e);
            throw $e;
        }
    }
}
