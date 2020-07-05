<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO;

use function array_search;
use function in_array;

class Collection implements OutputInterface
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function addItem(ItemInterface $item): bool
    {
        if ($this->hasItem($item)) {
            return false;
        }

        $this->items[] = $item;
        return true;
    }

    public function hasItem(ItemInterface $item): bool
    {
        return in_array($item, $this->items);
    }

    public function removeItem(ItemInterface $item): bool
    {
        if (!$this->hasItem($item)) {
            return false;
        }

        $itemKey = array_search($item, $this->items);
        unset($this->items[$itemKey]);
        return true;
    }

    public function toArray(): array
    {
        $returnData = [];

        foreach ($this->items as $item) {
            $returnData[] = $item->toArray();
        }

        return $returnData;
    }
}
