<?php

namespace App\Application\Queries\Category\Find;

use App\Domain\Entity\Category;
use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\CategoryRepositoryInterface;

readonly class FindCategoryQueryHandler implements QueryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(FindCategoryQuery $query): ?Category
    {
        return $this->categoryRepository->find($query->getCategoryId());
    }
}
