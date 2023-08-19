<?php

namespace App\Presentation\Admin\Priority;

use App\Domain\Entity\Priority;
use App\Presentation\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\ParamConverts\PriorityConverter;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Commands\Priority\Delete\DeletePriorityCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route(
    path: '/api/admin/priority/{priority}',
    requirements: [
        'priority' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_DELETE,
)]
#[ParamConverter('priority', class: PriorityConverter::class)]
class DeleteController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
    ) {
    }

    public function __invoke(Priority $priority,
    ): void {
        $this->commandBus->handle(new DeletePriorityCommand([
            'priority' => $priority,
        ]));
    }
}
