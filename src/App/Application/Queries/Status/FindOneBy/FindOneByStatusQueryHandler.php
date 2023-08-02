<?php

namespace App\Application\Queries\Status\FindOneBy;

use App\Domain\Entity\Status;
use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\StatusRepositoryInterface;

readonly class FindOneByStatusQueryHandler implements QueryHandler
{
    public function __construct(
        private StatusRepositoryInterface $statusRepository,
    ) {
    }

    public function __invoke(FindOneByStatusQuery $query): ?Status
    {
        return $this->statusRepository->findOneBy($query->getOptions());
    }
}
