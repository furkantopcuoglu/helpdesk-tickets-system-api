<?php

namespace App\Application\Queries\Priority\Find;

use App\Domain\Entity\Priority;
use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\PriorityRepositoryInterface;

readonly class FindPriorityQueryHandler implements QueryHandler
{
    public function __construct(
        private PriorityRepositoryInterface $priorityRepository,
    ) {
    }

    public function __invoke(FindPriorityQuery $query): ?Priority
    {
        return $this->priorityRepository->find($query->getPriorityId());
    }
}
