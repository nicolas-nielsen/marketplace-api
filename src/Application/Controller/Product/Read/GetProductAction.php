<?php

declare(strict_types=1);

namespace App\Application\Controller\Product\Read;

use App\Domain\Product\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetProductAction extends AbstractController
{
    #[Route(path: '/products', name: 'app.get.product', methods: ['GET'])]
    public function __invoke(): Response
    {
        $product = new Product(title: 'product 1', description: 'product 1 description', slug: 'product-1');

        return $this->json($product->toArray());
    }
}
