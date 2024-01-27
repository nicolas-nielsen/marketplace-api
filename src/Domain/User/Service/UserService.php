<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Dto\CreateUserDto;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function get(string $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function userExists(string $email): bool
    {
        return (bool) $this->userRepository->findOneBy(['email' => $email]);
    }

    public function registerUser(CreateUserDto $authRegisterDto): User
    {
        $user = new User(
            $authRegisterDto->getFirstname(),
            $authRegisterDto->getLastname(),
            $authRegisterDto->getEmail(),
            $authRegisterDto->getPassword()
        );

        $user->applyHashedPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));

        $this->userRepository->save($user);

        return $user;
    }
}
