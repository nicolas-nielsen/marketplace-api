<?php

declare(strict_types=1);

namespace App\Domain\Core;

use Symfony\Component\Serializer\Annotation\Groups;

#[Groups(['pagination'])]
class PaginationParameters
{
    public function __construct(
        private readonly int $page = 1,
        private readonly int $limit = 10
    ) {
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
