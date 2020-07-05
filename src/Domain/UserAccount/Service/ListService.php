<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\UserAccount\Entity\AccountCollection;

final class ListService extends AbstractService
{
    public function handleList(): AccountCollection
    {
        return $this
            ->getRepository()
            ->list()
        ;
    }
}
