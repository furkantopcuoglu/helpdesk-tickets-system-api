<?php

namespace App\Application\Queries\Category\FindOneBy;

use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\CategoryRepositoryInterface;

readonly class FindOneByCategoryQueryHandler implements QueryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(FindOneByCategoryQuery $query)
    {
        return $this->categoryRepository->findOneBy($query->getOptions());
    }
}
