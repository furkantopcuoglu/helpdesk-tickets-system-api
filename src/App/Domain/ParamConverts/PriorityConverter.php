<?php

namespace App\Domain\ParamConverts;

use App\Domain\Entity\Priority;
use App\Domain\Exceptions\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Priority\Find\FindPriorityQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

readonly class PriorityConverter implements ParamConverterInterface
{
    public function __construct(
        private MessengerQueryBus $queryBus,
    ) {
    }

    public function apply(Request $request, ParamConverter $configuration): true
    {
        $uuid = $request->attributes->get($configuration->getName());

        /** @var Priority|null $isExistPriority */
        $isExistPriority = $this->queryBus->handle(new FindPriorityQuery($uuid));

        if (!($isExistPriority instanceof Priority)) {
            throw new NotFoundException('NOT_FOUND_PRIORITY');
        }

        $request->attributes->set($configuration->getName(), $isExistPriority);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return PriorityConverter::class === $configuration->getClass();
    }
}
