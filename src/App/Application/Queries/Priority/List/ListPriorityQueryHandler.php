<?php

namespace App\Application\Queries\Priority\List;

use App\Domain\Repository\PriorityRepositoryInterface;

readonly class ListPriorityQueryHandler
{
    public function __construct(
        private PriorityRepositoryInterface $priorityRepository,
    ) {
    }

    public function handle()
    {
        return $this->priorityRepository->listAll();
    }
}
