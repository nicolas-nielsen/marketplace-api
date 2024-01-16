<?php

declare(strict_types=1);

namespace App\Domain\Product\Service;

use App\Domain\Product\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;

class ProductService
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    /**
     * @return Product[]
     */
    public function getAll(): array
    {
        return $this->productRepository->findAll();
    }
}
