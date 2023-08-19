<?php

namespace App\Presentation\Admin\Category;

use App\Domain\Entity\Category;
use App\Presentation\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\ParamConverts\CategoryConverter;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Commands\Category\Delete\DeleteCategoryCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route(
    path: '/api/admin/category/{category}',
    requirements: [
        'category' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_DELETE,
)]
#[ParamConverter('category', class: CategoryConverter::class)]
class DeleteController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
    ) {
    }

    public function __invoke(Category $category): void
    {
        $this->commandBus->handle(new DeleteCategoryCommand([
            'category' => $category,
        ]));
    }
}
