<?php

namespace App\Presentation\Admin\Category;

use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Category\List\ListCategoryQuery;

#[Route(
    path: '/api/admin/category',
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
        $allCategory = $this->queryBus->handle(new ListCategoryQuery());

        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($this->createSerializer()->normalize($allCategory,
                format: JsonEncoder::FORMAT,
            ));
    }
}
