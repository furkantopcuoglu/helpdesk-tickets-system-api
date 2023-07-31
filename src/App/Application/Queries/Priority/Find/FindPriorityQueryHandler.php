<?php

namespace App\Application\Queries\Priority\Find;

use App\Domain\Entity\Priority;
use App\Domain\Repository\PriorityRepositoryInterface;

readonly class FindPriorityQueryHandler
{
    public function __construct(
        private PriorityRepositoryInterface $priorityRepository,
    ) {
    }

    public function handle(FindPriorityQuery $query): ?Priority
    {
        return $this->priorityRepository->find($query->getPriorityId());
    }
}
