<?php

namespace App\Application\Queries\Category\Find;

use App\Domain\Entity\Category;
use App\Domain\Repository\CategoryRepositoryInterface;

readonly class FindCategoryQueryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function handle(FindCategoryQuery $query): ?Category
    {
        return $this->categoryRepository->find($query->getCategoryId());
    }
}
