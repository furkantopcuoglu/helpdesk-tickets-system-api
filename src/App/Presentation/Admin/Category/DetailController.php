<?php

namespace App\Presentation\Admin\Category;

use App\Domain\Entity\Category;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Category\Find\FindCategoryQuery;

#[Route(
    path: '/api/admin/category/{categoryId}',
    requirements: [
        'categoryId' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_GET,
)]
class DetailController extends AbstractController
{
    public function __construct(
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(string $categoryId): Payload
    {
        /** @var Category|null $isExistCategory */
        $isExistCategory = $this->queryBus->handle(new FindCategoryQuery($categoryId));

        if (!($isExistCategory instanceof Category)) {
            throw new BadRequestException('NOT_FOUND_CATEGORY');
        }

        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($this->createSerializer()->normalize($isExistCategory));
    }
}
