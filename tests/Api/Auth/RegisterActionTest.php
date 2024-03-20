<?php

declare(strict_types=1);

namespace App\Tests\Api\Auth;

use App\Tests\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterActionTest extends ApiTestCase
{
    public function testInvoke(): void
    {
        $this->response = $this->getClient()->request(
            Request::METHOD_POST,
            '/auth/register',
            [
                'body' => json_encode([
                    'firstname' => 'Jane',
                    'lastname' => 'Doe',
                    'email' => 'jane.doe@test.com',
                    'password' => 'twocarrots',
                ], \JSON_THROW_ON_ERROR),
            ]
        );

        $content = json_decode($this->response->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        $this->responseIsJson();
        $this->responseCodeIs(Response::HTTP_CREATED);
        $this->responseContainsJson([
            'id' => $content['id'],
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'jane.doe@test.com',
        ]);
    }

    public function testEmailInvalid(): void
    {
        $this->response = $this->getClient()->request(
            Request::METHOD_POST,
            '/auth/register',
            [
                'body' => json_encode([
                    'firstname' => 'Ant',
                    'lastname' => 'Slug',
                    'email' => 'ant.slug@test',
                    'password' => 'twocarrots',
                ], \JSON_THROW_ON_ERROR),
            ]
        );

        $this->responseCodeIs(Response::HTTP_BAD_REQUEST);
    }
}
