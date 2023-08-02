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
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Status\Find\FindStatusQuery;

#[Route(
    path: '/api/admin/status/{statusId}',
    requirements: [
        'statusId' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_GET,
)]
class DetailController extends AbstractController
{
    public function __construct(
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(string $statusId): Payload
    {
        /** @var Status|null $isExistStatus */
        $isExistStatus = $this->queryBus->handle(new FindStatusQuery($statusId));

        if (!($isExistStatus instanceof Status)) {
            throw new BadRequestException('NOT_FOUND_STATUS');
        }

        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($this->createSerializer()->normalize($isExistStatus));
    }
}
