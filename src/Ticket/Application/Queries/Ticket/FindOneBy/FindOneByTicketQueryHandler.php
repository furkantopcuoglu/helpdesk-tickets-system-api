<?php

namespace Ticket\Application\Queries\Ticket\FindOneBy;

use Ticket\Domain\Entity\Ticket;
use Common\Domain\Bus\Query\QueryHandler;
use Ticket\Domain\Repository\TicketRepositoryInterface;

readonly class FindOneByTicketQueryHandler implements QueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository,
    ) {
    }

    public function __invoke(FindOneByTicketQuery $query): ?Ticket
    {
        $options = $query->getOptions();

        if ($query->hasParameter('isAssigment') && !$query->isAssigment) {
            $options['support'] = null;
        }

        unset($options['isAssigment']);

        return $this->ticketRepository->findOneBy($options);
    }
}
