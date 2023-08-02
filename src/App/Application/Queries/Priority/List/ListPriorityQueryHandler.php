<?php

namespace App\Application\Queries\Priority\List;

use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\PriorityRepositoryInterface;

readonly class ListPriorityQueryHandler implements QueryHandler
{
    public function __construct(
        private PriorityRepositoryInterface $priorityRepository,
    ) {
    }

    public function __invoke(ListPriorityQuery $query)
    {
        return $this->priorityRepository->listAll();
    }
}
