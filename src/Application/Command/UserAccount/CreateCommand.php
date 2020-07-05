<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Application\Factory\UserAccount\CreateFactory;
use App\Domain\Service\UserAccount\CreateService;

class CreateCommand
{
    private CreateService $createService;

    public function __construct(CreateService $createService)
    {
        $this->createService = $createService;
    }

    public function execute(array $data)
    {
        $userAccount = CreateFactory::createFromRequest($data);

        $userAccount = $this
            ->createService
            ->createUserAccount($userAccount)
        ;
    }
}
