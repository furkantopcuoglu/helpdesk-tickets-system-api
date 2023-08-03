<?php

namespace Common\Application\Queries\Media\Find;

use Common\Domain\Entity\Media;
use Common\Domain\Bus\Query\QueryHandler;
use Common\Domain\Repository\MediaRepositoryInterface;

readonly class FindMediaQueryHandler implements QueryHandler
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository,
    ) {
    }

    public function __invoke(FindMediaQuery $query): ?Media
    {
        return $this->mediaRepository->find($query->getMediaId());
    }
}
