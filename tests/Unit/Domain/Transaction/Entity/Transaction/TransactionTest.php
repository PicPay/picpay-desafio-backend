<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transaction;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transaction\Account;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TransactionTest extends TestCase
{
    public function testAttributes(): void
    {
        $uuidExpected = new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e');
        $accountPayerExpected = $this->getAccount();
        $accountPayeeExpected = $this->getAccount();
        $transactionAmountExpected = new TransactionAmount(1250);
        $authenticationExpected = 'BR8166940296824476522617194O9';
        $createdAtExpected = new DateTime('2020-07-07 19:00:00');

        $transaction = new Transaction();
        $transaction->setUuid($uuidExpected);
        $transaction->setAccountPayer($accountPayerExpected);
        $transaction->setAccountPayee($accountPayeeExpected);
        $transaction->setAmount($transactionAmountExpected);
        $transaction->setAuthentication($authenticationExpected);
        $transaction->setCreatedAt($createdAtExpected);

        self::assertEquals($uuidExpected, $transaction->getUuid());
        self::assertEquals($accountPayerExpected, $transaction->getAccountPayer());
        self::assertEquals($accountPayeeExpected, $transaction->getAccountPayee());
        self::assertEquals($transactionAmountExpected, $transaction->getAmount());
        self::assertEquals($authenticationExpected, $transaction->getAuthentication());
        self::assertEquals($createdAtExpected, $transaction->getCreatedAt());
    }

    private function getAccount(): Account
    {
        $account = new Account();
        $account->setUuid(
            new UuidV4(
                Uuid
                    ::uuid4()
                    ->toString()
            )
        );
        $account->setDocument(new Document('57588899034'));

        return $account;
    }
}
