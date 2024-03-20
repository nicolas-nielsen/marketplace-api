<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Domain\Core\PaginatedCollection;
use App\Domain\Core\PaginationParameters;
use App\Domain\Product\Product;

/**
 * @method Product[]    findAll()
 * @method Product|null findOneBy(array $criteria, ?array $orderBy = null)
 */
interface ProductRepositoryInterface
{
    public function getPaginated(PaginationParameters $parameters): PaginatedCollection;
}
