<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Core\TimestampableTrait;
use Symfony\Component\Uid\Uuid;

class Product
{
    use TimestampableTrait;

    private Uuid $id;

    public function __construct(
        private string $title,
        private string $description,
        private string $slug,
    ) {
        $this->id = Uuid::v4();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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

    /**
     * @return array<string, string|Uuid>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
        ];
    }
}
