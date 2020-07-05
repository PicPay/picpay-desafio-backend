<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Application\Factory\UserAccount\CreateFactory;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Service\CreateService;

class CreateCommand
{
    private CreateService $createService;

    public function __construct(CreateService $createService)
    {
        $this->createService = $createService;
    }

    public function execute(array $data): Account
    {
        $account = CreateFactory::createFromRequest($data);

        return $this
            ->createService
            ->handleCreate($account)
        ;
    }
}
