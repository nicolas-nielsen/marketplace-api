<?php

declare(strict_types=1);

namespace App\Domain\Core;

trait TimestampableTrait
{
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt ?? new \DateTime();

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt ?? new \DateTime();

        return $this;
    }
}
