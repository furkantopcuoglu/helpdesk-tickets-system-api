<?php

namespace App\Presentation\App\Status;

use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Status\List\ListStatusQuery;

#[Route(
    path: '/api/status',
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
        $allStatus = $this->queryBus->handle(new ListStatusQuery());

        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($this->createSerializer()->normalize($allStatus,
                format: JsonEncoder::FORMAT,
            ));
    }
}
