<?php

namespace App\Domain\ValueObjects;

class CategoryId
{
    public function __construct(
        private readonly string $categoryId,
    ) {
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }
}
