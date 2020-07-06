<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Service\GetService;

class GetCommand
{
    private GetService $getService;

    public function __construct(GetService $getService)
    {
        $this->getService = $getService;
    }

    public function execute(string $accountUuid): Account
    {
        return $this
            ->getService
            ->handleGet($accountUuid)
        ;
    }
}
