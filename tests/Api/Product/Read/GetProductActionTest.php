<?php

declare(strict_types=1);

namespace App\Tests\Api\Product\Read;

use App\Domain\Product\ProductStatus;
use App\Tests\Api\ApiTestCase;
use App\Tests\Fixtures\FixtureIds;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetProductActionTest extends ApiTestCase
{
    private const RESOURCE_URI = '/products/';

    public function testInvoke(): void
    {
        $this->authenticatedAs(FixtureIds::USER_1);

        $this->response = $this->getClient()->request(
            Request::METHOD_GET,
            self::RESOURCE_URI.FixtureIds::PRODUCT_1
        );

        $this->responseIsJson();
        $this->responseCodeIs(Response::HTTP_OK);
        $this->responseContainsJson([
            'id' => FixtureIds::PRODUCT_1,
            'title' => 'Atmosphere Hoodie',
            'description' => 'Rhymesayers atmosphere hoodie blue',
            'slug' => 'atmosphere-hoodie',
            'category' => [],
            'status' => ProductStatus::NEW->value,
            'createdAt' => '2024-01-01T10:00:00+00:00',
            'updatedAt' => '2024-01-01T10:00:00+00:00',
        ]);
    }

    public function testNotValidId(): void
    {
        $this->authenticatedAs(FixtureIds::USER_1);

        $this->response = $this->getClient()->request(
            Request::METHOD_GET,
            self::RESOURCE_URI.'fakeId'
        );

        $this->responseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function testProductNotFound(): void
    {
        $this->authenticatedAs(FixtureIds::USER_1);

        $this->response = $this->getClient()->request(
            Request::METHOD_GET,
            self::RESOURCE_URI.FixtureIds::NOT_FOUND_RESOURCE
        );

        $this->responseCodeIs(Response::HTTP_NOT_FOUND);
    }

    public function testUnauthorized(): void
    {
        $this->response = $this->getClient()->request(
            Request::METHOD_GET,
            self::RESOURCE_URI.FixtureIds::PRODUCT_1
        );

        $this->responseCodeIs(Response::HTTP_UNAUTHORIZED);
    }
}
