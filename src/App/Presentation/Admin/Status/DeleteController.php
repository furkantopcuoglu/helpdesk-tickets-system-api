<?php

namespace App\Presentation\Admin\Status;

use App\Domain\Entity\Status;
use App\Presentation\AbstractController;
use App\Domain\ParamConverts\StatusConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Commands\Status\Delete\DeleteStatusCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route(
    path: '/api/admin/status/{status}',
    requirements: [
        'status' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_DELETE,
)]
#[ParamConverter('status', class: StatusConverter::class)]
class DeleteController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
    ) {
    }

    public function __invoke(Status $status): void
    {
        $this->commandBus->handle(new DeleteStatusCommand([
            'status' => $status,
        ]));
    }
}
