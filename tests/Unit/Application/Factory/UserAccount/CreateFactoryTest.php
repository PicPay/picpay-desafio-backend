<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Factory\UserAccount;

use App\Application\Factory\UserAccount\CreateFactory;
use App\Domain\UserAccount\Entity\Account;
use PHPUnit\Framework\TestCase;

class CreateFactoryTest extends TestCase
{
    public function testCreateFromRequest(): void
    {
        $requestData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'document' => '00412651068',
            'email' => 'john@doe.com',
            'password' => '123456',
        ];
        $account = CreateFactory::createFromRequest($requestData);

        self::assertInstanceOf(Account::class, $account);
    }
}
