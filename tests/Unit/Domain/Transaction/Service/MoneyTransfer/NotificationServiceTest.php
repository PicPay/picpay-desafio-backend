<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Component\Vendor\NotificationBazQux\ApiClient\ApiClientInterface;
use App\Domain\Transaction\Entity\Transaction\Account;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Service\NotificationService;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class NotificationServiceTest extends TestCase
{
    public function testHandleNotificationNewTransaction(): void
    {
        $transaction = $this->getTransaction();

        $apiClient = Mockery::mock(ApiClientInterface::class);
        $apiClient
            ->shouldReceive('createTransactionRefundOperation')
            ->withArgs([$transaction])
            ->andReturn(true)
        ;

        $notificationService = new NotificationService($apiClient);
        $notificationService->handleNotificationNewTransaction($transaction);

        self::assertTrue(true);
    }

    private function getTransaction(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setUuid(new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e'));
        $transaction->setAccountPayer($this->getTransactionAccount());
        $transaction->setAccountPayee($this->getTransactionAccount());
        $transaction->setAmount(new TransactionAmount(1250));
        $transaction->setAuthentication('BR8166940296824476522617194O9');
        $transaction->setCreatedAt(new DateTime('2020-07-07 19:00:00'));

        return $transaction;
    }

    private function getTransactionAccount(): Account
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
