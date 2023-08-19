<?php

namespace App\Presentation\Admin\Priority;

use App\Domain\Entity\Priority;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\ParamConverts\PriorityConverter;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Application\RequestDto\Priority\CreatePriorityRequestDto;
use App\Application\Commands\Priority\Update\UpdatePriorityCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Application\Queries\Priority\FindOneBy\FindOneByPriorityQuery;

#[Route(
    path: '/api/admin/priority/{priority}',
    requirements: [
        'priority' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_PUT,
)]
#[ParamConverter('priority', class: PriorityConverter::class)]
class UpdateController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(
        Priority $priority,
        #[MapRequestPayload] CreatePriorityRequestDto $createPriorityRequestDto,
    ): Payload {
        /** @var Priority|null $isExistName */
        $isExistName = $this->queryBus->handle(new FindOneByPriorityQuery([
            'name' => $createPriorityRequestDto->name,
        ]));

        if (
            ($isExistName instanceof Priority)
            && !$isExistName->getId()->equals($priority->getId())
        ) {
            throw new BadRequestException('PRIORITY_EXIST');
        }

        /** @var Priority $priority */
        $priority = $this->commandBus->handle(new UpdatePriorityCommand([
            'priority' => $priority,
            'name' => $createPriorityRequestDto->name,
            'color' => $createPriorityRequestDto->color,
        ]));

        return $this->createPayload()
            ->setStatus(PayloadStatus::UPDATED)
            ->setExtras($this->createSerializer()->normalize($priority))
            ->setOutput($createPriorityRequestDto);
    }
}
