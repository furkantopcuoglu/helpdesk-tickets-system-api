<?php

namespace App\Presentation\Admin\Category;

use App\Domain\Entity\Category;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\ParamConverts\CategoryConverter;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Application\RequestDto\Category\CreateCategoryRequestDto;
use App\Application\Commands\Category\Update\UpdateCategoryCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Application\Queries\Category\FindOneBy\FindOneByCategoryQuery;

#[Route(
    path: '/api/admin/category/{category}',
    requirements: [
        'category' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_PUT,
)]
#[ParamConverter('category', class: CategoryConverter::class)]
class UpdateController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(
        Category $category,
        #[MapRequestPayload] CreateCategoryRequestDto $createCategoryRequestDto,
    ): Payload {
        /** @var Category|null $isExistName */
        $isExistName = $this->queryBus->handle(new FindOneByCategoryQuery([
            'name' => $createCategoryRequestDto->name,
        ]));

        if (
            ($isExistName instanceof Category)
            && !$isExistName->getId()->equals($category->getId())
        ) {
            throw new BadRequestException('CATEGORY_EXIST');
        }

        /** @var Category $category */
        $category = $this->commandBus->handle(new UpdateCategoryCommand([
            'category' => $category,
            'name' => $createCategoryRequestDto->name,
            'color' => $createCategoryRequestDto->color,
        ]));

        return $this->createPayload()
            ->setStatus(PayloadStatus::UPDATED)
            ->setExtras($this->createSerializer()->normalize($category))
            ->setOutput($createCategoryRequestDto);
    }
}
