<?php

namespace App\Application\Queries\Category\FindOneBy;

use App\Domain\Repository\CategoryRepositoryInterface;

readonly class FindOneByCategoryQueryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function handle(FindOneByCategoryQuery $query)
    {
        return $this->categoryRepository->findOneBy($query->getOptions());
    }
}
