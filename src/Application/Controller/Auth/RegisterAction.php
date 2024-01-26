<?php

declare(strict_types=1);

namespace App\Application\Controller\Auth;

use App\Application\Controller\AbstractController;
use App\Domain\User\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

class RegisterAction extends AbstractController
{
    #[Route(path: '/register', name: 'app.register', methods: ['POST'])]
    public function __invoke(
        Request $request,
        UserService $userService
    ): Response {
        $body = json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        if ($userService->userExists($body['email'])) {
            throw new BadRequestHttpException(sprintf('Email %s is already registered', $body['email']));
        }

        $user = $userService->registerUser($body);

        return $this->json($user, 201, [], ['groups' => 'user_details']);
    }
}
