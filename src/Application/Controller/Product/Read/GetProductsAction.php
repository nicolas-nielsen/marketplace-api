<?php

declare(strict_types=1);

namespace App\Application\Controller\Product\Read;

use App\Application\Controller\AbstractController;
use App\Domain\Product\Service\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetProductsAction extends AbstractController
{
    #[Route(path: '/products', name: 'app.get.product_list', methods: ['GET'])]
    public function __invoke(
        Request $request,
        ProductService $productService
    ): Response {
        $groups = $this->getSerializationGroups();

        $products = $productService->getAll();

        return $this->json($products, 200, [], ['groups' => array_merge(['product_detail'], $groups)]);
    }
}
