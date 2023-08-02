<?php

namespace App\Presentation\Admin\Status;

use App\Domain\Entity\Status;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\RequestDto\Status\CreateStatusRequestDto;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Application\Commands\Status\Create\CreateStatusCommand;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Application\Queries\Status\FindOneBy\FindOneByStatusQuery;

#[Route(
    path: '/api/admin/status',
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
        #[MapRequestPayload] CreateStatusRequestDto $createStatusRequestDto,
    ): Payload {
        /** @var Status|null $isExistStatus */
        $isExistStatus = $this->queryBus->handle(new FindOneByStatusQuery([
            'name' => $createStatusRequestDto->name,
        ]));

        if ($isExistStatus instanceof Status) {
            throw new BadRequestException('STATUS_EXIST');
        }

        /** @var Status $status */
        $status = $this->commandBus->handle(new CreateStatusCommand($createStatusRequestDto->toArray()));

        return $this->createPayload()
            ->setStatus(PayloadStatus::CREATED)
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
