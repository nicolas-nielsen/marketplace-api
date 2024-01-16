<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Domain\Core\TimestampableTrait;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[Groups(['category_detail'])]
class Category
{
    use TimestampableTrait;

    #[Groups(['category_link'])]
    private Uuid $id;

    public function __construct(
        private string $title,
        private string $description,
        private string $slug,
        private int $level,
        private ?self $parent = null,
    ) {
        $this->id = Uuid::v4();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**  @phpstan-ignore-next-line */
    public static function createFixture(array $data): self
    {
        $self = new self(
            title: $data['title'] ?? '',
            description: $data['description'] ?? '',
            slug: $data['slug'] ?? '',
            level: $data['level'],
            parent: $data['parent'] ?? null
        );

        $self->id = $data['id'] ? Uuid::fromString($data['id']) : Uuid::v4();

        return $self;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }
}
