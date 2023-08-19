<?php

namespace App\Presentation\Admin\Status;

use App\Domain\Entity\Status;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use App\Domain\ParamConverts\StatusConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\RequestDto\Status\CreateStatusRequestDto;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Application\Commands\Status\Update\UpdateStatusCommand;
use App\Application\Queries\Status\FindOneBy\FindOneByStatusQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route(
    path: '/api/admin/status/{status}',
    requirements: [
        'status' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_PUT,
)]
#[ParamConverter('status', class: StatusConverter::class)]
class UpdateController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(
        Status $status,
        #[MapRequestPayload] CreateStatusRequestDto $createStatusRequestDto,
    ): Payload {
        /** @var Status|null $isExistName */
        $isExistName = $this->queryBus->handle(new FindOneByStatusQuery([
            'name' => $createStatusRequestDto->name,
        ]));

        if (
            ($isExistName instanceof Status)
            && !$isExistName->getId()->equals($status->getId())
        ) {
            throw new BadRequestException('STATUS_EXIST');
        }

        /** @var Status $status */
        $status = $this->commandBus->handle(new UpdateStatusCommand([
            'status' => $status,
            'name' => $createStatusRequestDto->name,
            'color' => $createStatusRequestDto->color,
        ]));

        return $this->createPayload()
            ->setStatus(PayloadStatus::UPDATED)
            ->setExtras($this->createSerializer()->normalize($status))
            ->setOutput($createStatusRequestDto);
    }
}
