<?php

namespace App\Presentation\Admin\Priority;

use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Priority\List\ListPriorityQuery;

#[Route(
    path: '/api/admin/priority',
    methods: Request::METHOD_GET,
)]
class IndexController extends AbstractController
{
    public function __construct(
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(): Payload
    {
        $allPriority = $this->queryBus->handle(new ListPriorityQuery());

        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($this->createSerializer()->normalize($allPriority,
                format: JsonEncoder::FORMAT,
            ));
    }
}
