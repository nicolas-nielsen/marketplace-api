<?php

declare(strict_types=1);

namespace App\Application\Controller\Product\Read;

use App\Domain\Product\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetProductAction extends AbstractController
{
    #[Route(path: '/products', name: 'app.get.product', methods: ['GET'])]
    public function __invoke(
        Request $request,
        ProductService $productService
    ): Response {
        $groups = $request->get('groups');

        $products = $productService->getAll();

        return $this->json($products, 200, [], ['groups' => array_merge(['product_detail', 'category_link'], (array) $groups)]);
    }
}
