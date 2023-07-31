<?php

namespace App\Application\Queries\User\Category\List;

use App\Domain\Entity\UserCategory;
use App\Domain\Repository\UserCategoryRepositoryInterface;

readonly class ListUserCategoryQueryHandler
{
    public function __construct(
        private UserCategoryRepositoryInterface $userCategoryRepository,
    ) {
    }

    public function handle(ListUserCategoryQuery $query): array
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
