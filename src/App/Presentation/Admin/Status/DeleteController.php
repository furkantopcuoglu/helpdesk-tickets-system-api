<?php

namespace App\Presentation\Admin\Status;

use App\Domain\Entity\Status;
use App\Presentation\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Status\Find\FindStatusQuery;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Commands\Status\Delete\DeleteStatusCommand;

#[Route(
    path: '/api/admin/status/{statusId}',
    requirements: [
        'statusId' => RouteRequirementUtil::uuid,
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
        string $statusId,
    ): void {
        /** @var Status|null $isExistStatus */
        $isExistStatus = $this->queryBus->handle(new FindStatusQuery($statusId));

        if (!($isExistStatus instanceof Status)) {
            throw new BadRequestException('NOT_FOUND_STATUS');
        }

        $this->commandBus->handle(new DeleteStatusCommand([
            'status' => $isExistStatus,
        ]));
    }
}
