<?php

declare(strict_types=1);

namespace App\Tests\Api\Product\Read;

use App\Domain\Product\ProductStatus;
use App\Tests\Api\ApiTestCase;
use App\Tests\Fixtures\FixtureIds;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetProductsActionTest extends ApiTestCase
{
    public function testInvoke(): void
    {
        $this->response = $this->getClient()->request(
            Request::METHOD_GET,
            '/products/'
        );

        $this->responseIsJson();
        $this->responseCodeIs(Response::HTTP_OK);
        $this->responseContainsJson([
            0 => [
                'id' => FixtureIds::PRODUCT_1,
                'title' => 'Atmosphere Hoodie',
                'description' => 'Rhymesayers atmosphere hoodie blue',
                'slug' => 'atmosphere-hoodie',
                'category' => [],
                'status' => ProductStatus::NEW->value,
                'createdAt' => '2024-01-17T14:25:13+00:00',
                'updatedAt' => '2024-01-17T14:25:13+00:00',
            ],
            1 => [
                'id' => FixtureIds::PRODUCT_2,
                'title' => 'The Clash T-shirt',
                'description' => 'The Clash t-shirt short sleeves',
                'slug' => 'the-clash-t-short-sleeves',
                'category' => [],
                'status' => ProductStatus::NEW->value,
                'createdAt' => '2024-01-17T14:25:13+00:00',
                'updatedAt' => '2024-01-17T14:25:13+00:00',
            ],
        ]);
    }
}
