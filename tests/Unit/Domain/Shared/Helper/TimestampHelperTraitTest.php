<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared\Helper;

use App\Domain\Shared\Helper\TimestampHelperTrait;
use DateTime;
use PHPUnit\Framework\TestCase;

class TimestampHelperTraitTest extends TestCase
{
    public function testAttributes(): void
    {
        $createdAtExpected = new DateTime('2020-07-05');
        $updatedAtExpected = new DateTime('2020-07-05');

        $object = new class {
            use TimestampHelperTrait;
        };

        self::assertNull($object->getUpdatedAt());

        $object->setCreatedAt($createdAtExpected);
        $object->setUpdatedAt($updatedAtExpected);

        self::assertEquals($createdAtExpected, $object->getCreatedAt());
        self::assertEquals($updatedAtExpected, $object->getUpdatedAt());
    }
}
