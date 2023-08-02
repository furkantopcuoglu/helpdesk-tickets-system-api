<?php

namespace App\Application\Queries\Priority\FindOneBy;

use App\Domain\Entity\Priority;
use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\PriorityRepositoryInterface;

readonly class FindOneByPriorityQueryHandler implements QueryHandler
{
    public function __construct(
        private PriorityRepositoryInterface $priorityRepository,
    ) {
    }

    public function __invoke(FindOneByPriorityQuery $query): ?Priority
    {
        return $this->priorityRepository->findOneBy($query->getOptions());
    }
}
