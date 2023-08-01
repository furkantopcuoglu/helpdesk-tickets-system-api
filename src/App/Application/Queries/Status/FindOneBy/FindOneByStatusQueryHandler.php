<?php

namespace App\Application\Queries\Status\FindOneBy;

use App\Domain\Entity\Status;
use App\Domain\Repository\StatusRepositoryInterface;

readonly class FindOneByStatusQueryHandler
{
    public function __construct(
        private StatusRepositoryInterface $statusRepository,
    ) {
    }

    public function handle(FindOneByStatusQuery $query): ?Status
    {
        return $this->statusRepository->findOneBy($query->getOptions());
    }
}
