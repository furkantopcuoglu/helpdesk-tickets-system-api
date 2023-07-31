<?php

namespace App\Application\Queries\Priority\FindOneBy;

use App\Domain\Entity\Priority;
use App\Domain\Repository\PriorityRepositoryInterface;

readonly class FindOneByPriorityQueryHandler
{
    public function __construct(
        private PriorityRepositoryInterface $priorityRepository,
    ) {
    }

    public function handle(FindOneByPriorityQuery $query): ?Priority
    {
        return $this->priorityRepository->findOneBy($query->getOptions());
    }
}
