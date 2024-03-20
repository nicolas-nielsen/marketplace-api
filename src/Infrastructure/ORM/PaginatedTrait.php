<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM;

use App\Domain\Core\PaginatedCollection;
use App\Domain\Core\PaginationParameters;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

trait PaginatedTrait
{
    public function paginateQuery(QueryBuilder $qb, PaginationParameters $paginationParameters): PaginatedCollection
    {
        $query = $qb->setMaxResults($paginationParameters->getLimit())
            ->setFirstResult(($paginationParameters->getPage() - 1) * $paginationParameters->getLimit())
            ->getQuery()
        ;

        $paginator = new Paginator($query);

        return new PaginatedCollection(new ArrayCollection(iterator_to_array($paginator->getIterator())), $paginator->count(), $paginationParameters);
    }
}
