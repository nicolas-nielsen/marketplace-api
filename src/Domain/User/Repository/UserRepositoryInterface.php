<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\User;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 */
interface UserRepositoryInterface
{
    public function save(User $user): void;
}
