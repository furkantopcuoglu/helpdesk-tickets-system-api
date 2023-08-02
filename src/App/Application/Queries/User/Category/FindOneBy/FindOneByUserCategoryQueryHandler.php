<?php

namespace App\Application\Queries\User\Category\FindOneBy;

use App\Domain\Entity\UserCategory;
use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\UserCategoryRepositoryInterface;

readonly class FindOneByUserCategoryQueryHandler implements QueryHandler
{
    public function __construct(
        private UserCategoryRepositoryInterface $userCategoryRepository,
    ) {
    }

    public function __invoke(FindOneByUserCategoryQuery $query): ?UserCategory
    {
        return $this->userCategoryRepository->findOneBy($query->getOptions());
    }
}
