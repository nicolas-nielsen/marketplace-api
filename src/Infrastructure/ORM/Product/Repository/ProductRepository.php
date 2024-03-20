<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Product\Repository;

use App\Domain\Core\PaginatedCollection;
use App\Domain\Core\PaginationParameters;
use App\Domain\Product\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Infrastructure\ORM\PaginatedTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    use PaginatedTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getPaginated(PaginationParameters $parameters): PaginatedCollection
    {
        $qb = $this->createQueryBuilder('p')
            ->select()
        ;

        return $this->paginateQuery($qb, $parameters);
    }
}
