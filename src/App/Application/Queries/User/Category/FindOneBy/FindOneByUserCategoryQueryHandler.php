<?php

namespace App\Application\Queries\User\Category\FindOneBy;

use App\Domain\Entity\UserCategory;
use App\Domain\Repository\UserCategoryRepositoryInterface;

readonly class FindOneByUserCategoryQueryHandler
{
    public function __construct(
        private UserCategoryRepositoryInterface $userCategoryRepository,
    ) {
    }

    public function handle(FindOneByUserCategoryQuery $query): ?UserCategory
    {
        return $this->userCategoryRepository->findOneBy($query->getOptions());
    }
}
