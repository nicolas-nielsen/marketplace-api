<?php

declare(strict_types=1);

namespace App\Application\Controller\Product\Read;

use App\Application\Controller\AbstractController;
use App\Domain\Product\Service\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class GetProductAction extends AbstractController
{
    #[Route(path: '/products/{id}', name: 'app.get.product_detail', methods: ['GET'])]
    public function __invoke(
        string $id,
        ProductService $productService,
    ): Response {
        if (!Uuid::isValid($id)) {
            throw new BadRequestHttpException('ID provided is not a valid UUID');
        }

        $groups = $this->getSerializationGroups();

        $product = $productService->findById($id);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->json($product, 200, [], ['groups' => array_merge(['product_detail'], $groups)]);
    }
}
