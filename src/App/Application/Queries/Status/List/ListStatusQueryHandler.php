<?php

namespace App\Application\Queries\Status\List;

use Common\Domain\Bus\Query\QueryHandler;
use App\Domain\Repository\StatusRepositoryInterface;

readonly class ListStatusQueryHandler implements QueryHandler
{
    public function __construct(
        private StatusRepositoryInterface $statusRepository,
    ) {
    }

    public function __invoke(ListStatusQuery $query)
    {
        return $this->statusRepository->listAll();
    }
}
