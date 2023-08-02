<?php

namespace App\Presentation\Admin\Priority;

use App\Domain\Entity\Priority;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Queries\Priority\Find\FindPriorityQuery;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Application\RequestDto\Priority\CreatePriorityRequestDto;
use App\Application\Commands\Priority\Update\UpdatePriorityCommand;
use App\Application\Queries\Priority\FindOneBy\FindOneByPriorityQuery;

#[Route(
    path: '/api/admin/priority/{priorityId}',
    requirements: [
        'priorityId' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_PUT,
)]
class UpdateController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(
        string $priorityId,
        #[MapRequestPayload] CreatePriorityRequestDto $createPriorityRequestDto,
    ): Payload {
        /** @var Priority|null $isExistPriority */
        $isExistPriority = $this->queryBus->handle(new FindPriorityQuery($priorityId));

        if (!($isExistPriority instanceof Priority)) {
            throw new BadRequestException('NOT_FOUND_PRIORITY');
        }

        /** @var Priority|null $isExistName */
        $isExistName = $this->queryBus->handle(new FindOneByPriorityQuery([
            'name' => $createPriorityRequestDto->name,
        ]));

        if (
            ($isExistName instanceof Priority)
            && !$isExistName->getId()->equals($isExistPriority->getId())
        ) {
            throw new BadRequestException('PRIORITY_EXIST');
        }

        /** @var Priority $priority */
        $priority = $this->commandBus->handle(new UpdatePriorityCommand([
            'priority' => $isExistPriority,
            'name' => $createPriorityRequestDto->name,
            'color' => $createPriorityRequestDto->color,
        ]));

        return $this->createPayload()
            ->setStatus(PayloadStatus::UPDATED)
            ->setExtras($this->createSerializer()->normalize($priority,
                format: JsonEncoder::FORMAT,
                context: [
                    AbstractNormalizer::ATTRIBUTES => [
                        'id',
                        'name',
                        'color',
                    ],
                ]))
            ->setOutput($createPriorityRequestDto);
    }
}
