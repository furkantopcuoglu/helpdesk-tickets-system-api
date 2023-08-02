<?php

namespace App\Application\Queries\Status\Find;

use App\Domain\Entity\Status;
use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\StatusRepositoryInterface;

readonly class FindStatusQueryHandler implements QueryHandler
{
    public function __construct(
        private StatusRepositoryInterface $statusRepository,
    ) {
    }

    public function __invoke(FindStatusQuery $query): ?Status
    {
        return $this->statusRepository->find($query->getStatusId());
    }
}
