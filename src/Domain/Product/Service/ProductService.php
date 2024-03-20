<?php

declare(strict_types=1);

namespace App\Domain\Product\Service;

use App\Domain\Core\PaginatedCollection;
use App\Domain\Core\PaginationParameters;
use App\Domain\Product\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;

class ProductService
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function getPaginated(PaginationParameters $parameters): PaginatedCollection
    {
        return $this->productRepository->getPaginated($parameters);
    }

    public function findById(string $id): ?Product
    {
        return $this->productRepository->findOneBy(['id' => $id]);
    }
}
