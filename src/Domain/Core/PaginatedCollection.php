<?php

declare(strict_types=1);

namespace App\Domain\Core;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[Groups(['pagination'])]
class PaginatedCollection
{
    public function __construct(
        private readonly Collection $items,
        private readonly int $total,
        private readonly PaginationParameters $parameters
    ) {
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getParameters(): PaginationParameters
    {
        return $this->parameters;
    }
}
