<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Repository;

use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;

interface AccountRepositoryInterface
{
    public function getPayerAccount(PayerAccount $payerAccount): PayerAccount;

    public function hasPayeeAccount(PayeeAccount $payeeAccount): bool;
}
