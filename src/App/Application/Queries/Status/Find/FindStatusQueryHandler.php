<?php

namespace App\Application\Queries\Status\Find;

use App\Domain\Entity\Status;
use App\Domain\Repository\StatusRepositoryInterface;

readonly class FindStatusQueryHandler
{
    public function __construct(
        private StatusRepositoryInterface $statusRepository,
    ) {
    }

    public function handle(FindStatusQuery $query): ?Status
    {
        return $this->statusRepository->find($query->getStatusId());
    }
}
