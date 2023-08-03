<?php

namespace App\Application\Queries\Category\List;

use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\CategoryRepositoryInterface;

readonly class ListCategoryQueryHandler implements QueryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(ListCategoryQuery $query)
    {
        return $this->categoryRepository->listAll($query);
    }
}
