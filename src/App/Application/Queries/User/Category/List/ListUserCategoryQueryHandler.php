<?php

namespace App\Application\Queries\User\Category\List;

use App\Domain\Entity\UserCategory;
use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\UserCategoryRepositoryInterface;

readonly class ListUserCategoryQueryHandler implements QueryHandler
{
    public function __construct(
        private UserCategoryRepositoryInterface $userCategoryRepository,
    ) {
    }

    public function __invoke(ListUserCategoryQuery $query): array
    {
        $userCategories = $this->userCategoryRepository->findBy([
            'user' => $query->user,
        ]);

        return collect($userCategories)->map(function (UserCategory $userCategory) {
            $category = $userCategory->getCategory();

            return [
                'id' => $category->getId()->toString(),
                'name' => $category->getName(),
                'color' => $category->getColor(),
                'isDefault' => $category->isDefault(),
            ];
        })->toArray();
    }
}
