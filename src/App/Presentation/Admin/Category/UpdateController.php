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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Queries\Category\Find\FindCategoryQuery;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Application\RequestDto\Category\CreateCategoryRequestDto;
use App\Application\Commands\Category\Update\UpdateCategoryCommand;
use App\Application\Queries\Category\FindOneBy\FindOneByCategoryQuery;

#[Route(
    path: '/api/admin/category/{categoryId}',
    requirements: [
        'categoryId' => RouteRequirementUtil::uuid,
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
        string $categoryId,
        #[MapRequestPayload] CreateCategoryRequestDto $createCategoryRequestDto,
    ): Payload {
        /** @var Category|null $isExistCategory */
        $isExistCategory = $this->queryBus->handle(new FindCategoryQuery($categoryId));

        if (!($isExistCategory instanceof Category)) {
            throw new BadRequestException('NOT_FOUND_CATEGORY');
        }

        /** @var Category|null $isExistName */
        $isExistName = $this->queryBus->handle(new FindOneByCategoryQuery([
            'name' => $createCategoryRequestDto->name,
        ]));

        if (
            ($isExistName instanceof Category)
            && !$isExistName->getId()->equals($isExistCategory->getId())
        ) {
            throw new BadRequestException('CATEGORY_EXIST');
        }

        /** @var Category $category */
        $category = $this->commandBus->handle(new UpdateCategoryCommand([
            'category' => $isExistCategory,
            'name' => $createCategoryRequestDto->name,
            'color' => $createCategoryRequestDto->color,
        ]));

        return $this->createPayload()
            ->setStatus(PayloadStatus::UPDATED)
            ->setExtras($this->createSerializer()->normalize($category,
                format: JsonEncoder::FORMAT,
                context: [
                    AbstractNormalizer::ATTRIBUTES => [
                        'id',
                        'name',
                        'color',
                        'isDefault',
                    ],
                ]))
            ->setOutput($createCategoryRequestDto);
    }
}
