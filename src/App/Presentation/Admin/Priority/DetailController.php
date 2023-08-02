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
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Priority\Find\FindPriorityQuery;

#[Route(
    path: '/api/admin/priority/{priorityId}',
    requirements: [
        'priorityId' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_GET,
)]
class DetailController extends AbstractController
{
    public function __construct(
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(string $priorityId): Payload
    {
        /** @var Priority|null $isExistPriority */
        $isExistPriority = $this->queryBus->handle(new FindPriorityQuery($priorityId));

        if (!($isExistPriority instanceof Priority)) {
            throw new BadRequestException('NOT_FOUND_PRIORITY');
        }

        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($this->createSerializer()->normalize($isExistPriority));
    }
}
