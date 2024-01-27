<?php

declare(strict_types=1);

namespace App\Application\Controller\Auth;

use App\Application\Controller\AbstractController;
use App\Application\Payload\Auth\AuthRegisterPayload;
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
        $payload = $this->createPayloadFromRequestContent($request->getContent(), AuthRegisterPayload::class);

        $createUserDto = $payload->buildCreateUserDto();

        if ($userService->userExists($createUserDto->getEmail())) {
            throw new BadRequestHttpException(sprintf('Email %s is already registered', $createUserDto->getEmail()));
        }

        $user = $userService->registerUser($createUserDto);

        return $this->json($user, 201, [], ['groups' => 'user_details']);
    }
}
