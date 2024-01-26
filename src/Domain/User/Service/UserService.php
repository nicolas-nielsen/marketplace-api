<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

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

    /** @param string[] $data */
    public function registerUser(array $data): User
    {
        $user = new User(
            $data['firstname'],
            $data['lastname'],
            $data['email'],
            $data['password']
        );

        $user->applyHashedPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));

        $this->userRepository->save($user);

        return $user;
    }
}
