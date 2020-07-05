<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\ValueObject\Uuid;

use App\Domain\Exception\ValueObject\Uuid\V4\InvalidValueException;
use App\Domain\ValueObject\Uuid\V4 as UuidV4;
use PHPUnit\Framework\TestCase;

class V4Test extends TestCase
{
    public function testAttributes(): void
    {
        $uuidExpected = 'fa24ccc6-26eb-48c1-8ceb-b9356dfca98e';
        $versionExpected = UuidV4::VERSION;
        $uuid = new UuidV4($uuidExpected);

        self::assertEquals($uuidExpected, $uuid->getValue());
        self::assertEquals($versionExpected, $uuid->getVersion());
    }

    public function testConstructThrowInvalidValueException(): void
    {
        self::expectException(InvalidValueException::class);

        new UuidV4('other');
    }

    public function testIsValid(): void
    {
        self::assertTrue(UuidV4::isValid('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e'));
    }

    public function testIsNotValid(): void
    {
        self::assertFalse(UuidV4::isValid('49910408-be55-11ea-b3de-0242ac130004'));
    }
}
