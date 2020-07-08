<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\DTO;

use App\Infrastructure\DTO\Collection;
use App\Infrastructure\DTO\ItemInterface;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testAttributes(): void
    {
        $collection = new Collection();

        self::assertCount(0, $collection->toArray());

        $itemOne = $this->getItemOne();
        $itemTwo = $this->getItemTwo();

        self::assertTrue($collection->addItem($itemOne));
        self::assertFalse($collection->addItem($itemOne));

        self::assertFalse($collection->hasItem($itemTwo));
        $collection->addItem($itemTwo);
        self::assertTrue($collection->hasItem($itemTwo));

        self::assertTrue($collection->removeItem($itemTwo));
        self::assertFalse($collection->removeItem($itemTwo));

        self::assertCount(1, $collection->toArray());
    }

    private function getItemOne(): ItemInterface
    {
        return new class implements ItemInterface {
            public function toArray(): array
            {
                return [
                    'time' => time(),
                ];
            }
        };
    }

    private function getItemTwo(): ItemInterface
    {
        return new class implements ItemInterface {
            public function toArray(): array
            {
                return [
                    'time' => time(),
                ];
            }
        };
    }
}
