<?php

namespace App\Presentation\Admin\Category;

use App\Domain\Entity\Category;
use App\Presentation\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Queries\Category\Find\FindCategoryQuery;
use App\Application\Commands\Category\Delete\DeleteCategoryCommand;

#[Route(
    path: '/api/admin/category/{categoryId}',
    requirements: [
        'categoryId' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_DELETE,
)]
class DeleteController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(
        string $categoryId,
    ): void {
        /** @var Category|null $isExistCategory */
        $isExistCategory = $this->queryBus->handle(new FindCategoryQuery($categoryId));

        if (!($isExistCategory instanceof Category)) {
            throw new BadRequestException('NOT_FOUND_CATEGORY');
        }

        $this->commandBus->handle(new DeleteCategoryCommand([
            'category' => $isExistCategory,
        ]));
    }
}
