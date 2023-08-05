<?php

namespace Ticket\Application\Queries\Ticket\Find;

use Ticket\Domain\Entity\Ticket;
use Common\Domain\Bus\Query\QueryHandler;
use Ticket\Domain\Repository\TicketRepositoryInterface;

readonly class FindTicketQueryHandler implements QueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository,
    ) {
    }

    public function __invoke(FindTicketQuery $query): ?Ticket
    {
        return $this->ticketRepository->find($query->getTicketId());
    }
}
