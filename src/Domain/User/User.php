<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Core\TimestampableTrait;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableTrait;

    #[Groups(['user_details_admin'])]
    private Uuid $id;

    /** @var string[] */
    #[Groups(['user_details_admin'])]
    private array $roles;

    public function __construct(
        #[Groups('user_details')]
        private string $firstname,
        #[Groups('user_details')]
        private string $lastname,
        #[Groups('user_details')]
        private string $email,
        #[Groups(['user_password'])]
        private string $password
    ) {
        $this->id = Uuid::v4();
        $this->roles = ['ROLE_USER'];
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**  @phpstan-ignore-next-line */
    public static function createFixture(array $data): self
    {
        $self = new self(
            firstname: $data['firstname'],
            lastname: $data['lastname'],
            email: $data['email'],
            password: $data['password'],
        );

        $self->id = $data['id'] ? Uuid::fromString($data['id']) : Uuid::v4();
        $self->createdAt = $data['createdAt'] ?? $self->createdAt;
        $self->updatedAt = $data['updatedAt'] ?? $self->updatedAt;

        return $self;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /** @return string[] */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function addRole(string $role): self
    {
        $this->roles[] = $role;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function applyHashedPassword(string $hashedPassword): self
    {
        $this->password = $hashedPassword;

        return $this;
    }
}
