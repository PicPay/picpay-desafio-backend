<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Service;

use App\Domain\UserAccount\Entity\AccountCollection;

interface ListServiceInterface
{
    public function handleList(): AccountCollection;
}
