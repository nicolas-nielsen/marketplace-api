<?php

declare(strict_types=1);

namespace App\Domain\Product;

enum ProductStatus: string
{
    case NEW = 'new';
    case SOLD = 'sold';
}
