<?php

namespace App\Application\Queries\Category\List;

use App\Domain\Repository\CategoryRepositoryInterface;

readonly class ListCategoryQueryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function handle()
    {
        return $this->categoryRepository->listAll();
    }
}
