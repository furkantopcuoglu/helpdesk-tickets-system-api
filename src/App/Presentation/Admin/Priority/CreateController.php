<?php

namespace App\Presentation\Admin\Priority;

use App\Domain\Entity\Priority;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Application\RequestDto\Priority\CreatePriorityRequestDto;
use App\Application\Commands\Priority\Create\CreatePriorityCommand;
use App\Application\Queries\Priority\FindOneBy\FindOneByPriorityQuery;

#[Route(
    path: '/api/admin/priority',
    methods: Request::METHOD_POST,
)]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] CreatePriorityRequestDto $createPriorityRequestDto,
    ): Payload {
        /** @var Priority|null $isExistPriority */
        $isExistPriority = $this->queryBus->handle(new FindOneByPriorityQuery([
            'name' => $createPriorityRequestDto->name,
        ]));

        if ($isExistPriority instanceof Priority) {
            throw new BadRequestException('PRIORITY_EXIST');
        }

        /** @var Priority $priority */
        $priority = $this->commandBus->handle(new CreatePriorityCommand($createPriorityRequestDto->toArray()));

        return $this->createPayload()
            ->setStatus(PayloadStatus::CREATED)
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
