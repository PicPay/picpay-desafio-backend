<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Application\Command\AbstractCommand;
use App\Application\Factory\UserAccount\CreateFactory;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Service\CreateServiceInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final class CreateCommand extends AbstractCommand
{
    private CreateServiceInterface $createService;

    public function __construct(
        CreateServiceInterface $createService,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
        $this->createService = $createService;
    }

    public function execute(array $data): Account
    {
        try {
            $account = CreateFactory::createFromRequest($data);

            return $this
                ->createService
                ->handleCreate($account)
            ;
        } catch (Throwable $e) {
            $this->logException($e);
            throw $e;
        }
    }
}
