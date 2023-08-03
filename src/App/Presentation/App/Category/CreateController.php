<?php

namespace App\Presentation\App\Category;

use App\Domain\Entity\Category;
use Common\Application\Utils\Payload;
use App\Application\Enum\CategoryType;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Application\Commands\Category\Create\CreateCategoryCommand;
use App\Application\Queries\Category\FindOneBy\FindOneByCategoryQuery;
use App\Application\RequestDto\Category\CreateCustomUserCategoryRequestDto;
use App\Application\Commands\User\Category\Create\CreateUserCategoryCommand;

#[Route(
    path: '/api/category',
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
        #[MapRequestPayload] CreateCustomUserCategoryRequestDto $dto,
    ): Payload {
        /** @var Category|null $isExistCategory */
        $isExistCategory = $this->queryBus->handle(new FindOneByCategoryQuery([
            'name' => $dto->name,
            'isDefault' => true,
        ]));

        if ($isExistCategory instanceof Category) {
            throw new BadRequestException('CATEGORY_EXIST');
        }

        /** @var Category $category */
        $category = $this->commandBus->handle(new CreateCategoryCommand([
            'name' => $dto->name,
            'color' => CategoryType::getColor(CategoryType::PROBLEM),
            'isDefault' => false,
        ]));

        // Create User Category
        $this->commandBus->handle(new CreateUserCategoryCommand([
            'user' => $this->getUser(),
            'category' => $category,
        ]));

        return $this->createPayload()
            ->setStatus(PayloadStatus::CREATED)
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
            ->setOutput($dto);
    }
}
