<?php

namespace Common\Application\Utils;

use Doctrine\ORM\Query;
use Pagerfanta\Pagerfanta;
use Doctrine\ORM\AbstractQuery;
use Pagerfanta\PagerfantaInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter as ORMQueryAdapter;

class Paginator
{
    public const PAGE_LIMIT = 20;
    private array $results;

    private PagerfantaInterface $pagerfanta;

    private int $page;
    private int $limit;

    public function __construct(
        int $page = 1,
        int $limit = self::PAGE_LIMIT,
    ) {
        $this->page = $page;
        $this->limit = $limit;
    }

    public function paginateWithORM(Query $query): self
    {
        $query->setHydrationMode(AbstractQuery::HYDRATE_ARRAY);

        $this->pagerfanta = new Pagerfanta(new ORMQueryAdapter($query));
        $this->pagerfanta->setMaxPerPage($this->limit);
        $this->pagerfanta->setCurrentPage($this->page);

        $this->results = (array) $this->pagerfanta->getIterator();

        return $this;
    }

    private function getTotalPage(): int
    {
        return (int) ceil($this->pagerfanta->getNbResults() / $this->limit);
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function setResults(array $results): void
    {
        $this->results = $results;
    }

    public function getResponse(): PaginationResponse
    {
        return new PaginationResponse($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'results' => $this->getResults(),
            'page' => $this->page,
            'perPage' => $this->limit,
            'totalPage' => $this->getTotalPage(),
            'total' => $this->pagerfanta->getNbResults(),
        ];
    }
}
