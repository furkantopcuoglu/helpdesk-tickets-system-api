<?php

namespace App\Presentation\App\Category;

use App\Domain\Entity\UserCategory;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Category\List\ListCategoryQuery;

#[Route(
    path: '/api/category',
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
        $allCategory = $this->queryBus->handle(new ListCategoryQuery([
            'isDefault' => true,
        ]));

        $userCategories = collect($this->getUser()->getUserCategories())->map(
            fn (UserCategory $userCategory) => $this->createSerializer()
                ->normalize(
                    $userCategory->getCategory(),
                    JsonEncoder::FORMAT,
                ),
        )->toArray();

        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras([...$allCategory, ...$userCategories]);
    }
}
