<?php

namespace App\Application\Queries\Status\List;

use App\Domain\Repository\StatusRepositoryInterface;

readonly class ListStatusQueryHandler
{
    public function __construct(
        private StatusRepositoryInterface $statusRepository,
    ) {
    }

    public function handle()
    {
        return $this->statusRepository->listAll();
    }
}
