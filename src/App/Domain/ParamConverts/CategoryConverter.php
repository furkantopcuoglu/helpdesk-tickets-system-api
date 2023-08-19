<?php

namespace App\Domain\ParamConverts;

use App\Domain\Entity\Category;
use App\Domain\Exceptions\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Category\Find\FindCategoryQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

readonly class CategoryConverter implements ParamConverterInterface
{
    public function __construct(
        private MessengerQueryBus $queryBus,
    ) {
    }

    public function apply(Request $request, ParamConverter $configuration): true
    {
        $uuid = $request->attributes->get($configuration->getName());

        /** @var Category|null $isExistCategory */
        $isExistCategory = $this->queryBus->handle(new FindCategoryQuery($uuid));

        if (!($isExistCategory instanceof Category)) {
            throw new NotFoundException('NOT_FOUND_CATEGORY');
        }

        $request->attributes->set($configuration->getName(), $isExistCategory);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return CategoryConverter::class === $configuration->getClass();
    }
}
