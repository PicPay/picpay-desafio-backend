<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Repository;

use App\Domain\Transaction\Entity\Transfer\AbstractAccount;

interface AccountRepositoryInterface
{
    public function get(AbstractAccount $account): AbstractAccount;
}
