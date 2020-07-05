<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Domain\UserAccount\Entity\AccountCollection;
use App\Domain\UserAccount\Service\ListService;

class ListCommand
{
    private ListService $listService;

    public function __construct(ListService $listService)
    {
        $this->listService = $listService;
    }

    public function execute(): AccountCollection
    {
        return $this
            ->listService
            ->handleList()
        ;
    }
}
