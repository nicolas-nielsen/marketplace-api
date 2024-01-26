<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Category\Category;
use App\Domain\Core\TimestampableTrait;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[Groups('product_detail')]
class Product
{
    use TimestampableTrait;

    #[Groups(['subressource_link'])]
    private Uuid $id;

    public function __construct(
        private string $title,
        private string $description,
        private string $slug,
        private Category $category,
        private ProductStatus $status = ProductStatus::NEW,
    ) {
        $this->id = Uuid::v4();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**  @phpstan-ignore-next-line */
    public static function createFixture(array $data): self
    {
        $self = new self(
            title: $data['title'],
            description: $data['description'],
            slug: $data['slug'],
            category: $data['category'],
            status: $data['status'] ? ProductStatus::from($data['status']) : ProductStatus::NEW
        );

        $self->createdAt = $data['createdAt'] ?? $self->createdAt;
        $self->updatedAt = $data['updatedAt'] ?? $self->updatedAt;
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

    public function getStatus(): ProductStatus
    {
        return $this->status;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}
