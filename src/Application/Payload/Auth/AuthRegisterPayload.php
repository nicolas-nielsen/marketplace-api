<?php

declare(strict_types=1);

namespace App\Application\Payload\Auth;

use App\Domain\User\Dto\CreateUserDto;
use Symfony\Component\Validator\Constraints as Assert;

class AuthRegisterPayload
{
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public mixed $firstname;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public mixed $lastname;

    #[Assert\Email]
    #[Assert\NotBlank]
    public mixed $email;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public mixed $password;

    public function buildCreateUserDto(): CreateUserDto
    {
        return new CreateUserDto(
            firstname: $this->firstname,
            lastname: $this->lastname,
            email: $this->email,
            password: $this->password
        );
    }
}
