<?php

namespace App\Presentation\Admin\Priority;

use App\Domain\Entity\Priority;
use App\Presentation\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Queries\Priority\Find\FindPriorityQuery;
use App\Application\Commands\Priority\Delete\DeletePriorityCommand;

#[Route(
    path: '/api/admin/priority/{priorityId}',
    requirements: [
        'priorityId' => RouteRequirementUtil::uuid,
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
        string $priorityId,
    ): void {
        /** @var Priority|null $isExistPriority */
        $isExistPriority = $this->queryBus->handle(new FindPriorityQuery($priorityId));

        if (!($isExistPriority instanceof Priority)) {
            throw new BadRequestException('NOT_FOUND_PRIORITY');
        }

        $this->commandBus->handle(new DeletePriorityCommand([
            'priority' => $isExistPriority,
        ]));
    }
}
