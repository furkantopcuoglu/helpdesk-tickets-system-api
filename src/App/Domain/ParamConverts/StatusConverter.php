<?php

namespace App\Domain\ParamConverts;

use App\Domain\Entity\Status;
use App\Domain\Exceptions\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use App\Application\Queries\Status\Find\FindStatusQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

readonly class StatusConverter implements ParamConverterInterface
{
    public function __construct(
        private MessengerQueryBus $queryBus,
    ) {
    }

    public function apply(Request $request, ParamConverter $configuration): true
    {
        $uuid = $request->attributes->get($configuration->getName());

        /** @var Status|null $isExistStatus */
        $isExistStatus = $this->queryBus->handle(new FindStatusQuery($uuid));

        if (!($isExistStatus instanceof Status)) {
            throw new NotFoundException('NOT_FOUND_STATUS');
        }

        $request->attributes->set($configuration->getName(), $isExistStatus);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return StatusConverter::class === $configuration->getClass();
    }
}
