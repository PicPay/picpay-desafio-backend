<?php

declare(strict_types=1);

namespace App\Domain\Shared\Helper;

use DateTimeInterface;

trait TimestampHelperTrait
{
    private DateTimeInterface $createdAt;
    private ?DateTimeInterface $updatedAt;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
