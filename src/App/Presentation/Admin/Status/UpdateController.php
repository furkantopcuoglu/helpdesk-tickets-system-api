<?php

namespace App\Presentation\Admin\Status;

use App\Domain\Entity\Status;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Status\Find\FindStatusQuery;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\RequestDto\Status\CreateStatusRequestDto;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Application\Commands\Status\Update\UpdateStatusCommand;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Application\Queries\Status\FindOneBy\FindOneByStatusQuery;

#[Route(
    path: '/api/admin/status/{statusId}',
    requirements: [
        'statusId' => RouteRequirementUtil::uuid,
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
        string $statusId,
        #[MapRequestPayload] CreateStatusRequestDto $createStatusRequestDto,
    ): Payload {
        /** @var Status|null $isExistStatus */
        $isExistStatus = $this->queryBus->handle(new FindStatusQuery($statusId));

        if (!($isExistStatus instanceof Status)) {
            throw new BadRequestException('NOT_FOUND_STATUS');
        }

        /** @var Status|null $isExistName */
        $isExistName = $this->queryBus->handle(new FindOneByStatusQuery([
            'name' => $createStatusRequestDto->name,
        ]));

        if (
            ($isExistName instanceof Status)
            && !$isExistName->getId()->equals($isExistStatus->getId())
        ) {
            throw new BadRequestException('STATUS_EXIST');
        }

        /** @var Status $status */
        $status = $this->commandBus->handle(new UpdateStatusCommand([
            'status' => $isExistStatus,
            'name' => $createStatusRequestDto->name,
            'color' => $createStatusRequestDto->color,
        ]));

        return $this->createPayload()
            ->setStatus(PayloadStatus::UPDATED)
            ->setExtras($this->createSerializer()->normalize($status,
                format: JsonEncoder::FORMAT,
                context: [
                    AbstractNormalizer::ATTRIBUTES => [
                        'id',
                        'name',
                        'color',
                    ],
                ]))
            ->setOutput($createStatusRequestDto);
    }
}
