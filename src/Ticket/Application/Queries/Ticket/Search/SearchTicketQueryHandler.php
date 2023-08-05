<?php

namespace Ticket\Application\Queries\Ticket\Search;

use Ticket\Domain\Entity\Ticket;
use Common\Application\Utils\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Query\QueryHandler;
use Common\Application\Utils\PaginationResponse;

readonly class SearchTicketQueryHandler implements QueryHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(SearchTicketQuery $query): PaginationResponse
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb
            ->select('ticket')
            ->addSelect('partial owner.{
                id,
                name,
                surname,
                email
            }')
            ->addSelect('partial support.{
                id,
                name,
                surname,
                email
            }')
            ->addSelect('category')
            ->addSelect('priority')
            ->addSelect('status')
            ->from(Ticket::class, 'ticket')
            ->leftJoin('ticket.owner', 'owner')
            ->leftJoin('ticket.support', 'support')
            ->leftJoin('ticket.category', 'category')
            ->leftJoin('ticket.priority', 'priority')
            ->leftJoin('ticket.status', 'status')
            ->orderBy('ticket.createdAt', 'DESC')
            ->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->eq('ticket.isArchive', 0),
                    $qb->expr()->eq('ticket.isDeleted', 0),
                ),
            )
        ;

        if ($query->hasParameter('ticketNo')) {
            $qb->andWhere($qb->expr()->eq('ticket.ticketNo', ':ticketNo'));
            $qb->setParameter('ticketNo', $query->ticketNo);
        }

        if ($query->hasParameter('subject')) {
            $qb->andWhere($qb->expr()->like('ticket.subject', ':subject'));
            $qb->setParameter('subject', '%'.$query->subject.'%');
        }

        if ($query->hasParameter('content')) {
            $qb->andWhere($qb->expr()->like('ticket.content', ':content'));
            $qb->setParameter('content', '%'.$query->content.'%');
        }

        if ($query->hasParameter('categoryId')) {
            $qb->andWhere($qb->expr()->eq('ticket.category', ':category'));
            $qb->setParameter('category', $query->categoryId);
        }

        if ($query->hasParameter('priorityId')) {
            $qb->andWhere($qb->expr()->eq('ticket.priority', ':priority'));
            $qb->setParameter('priority', $query->priorityId);
        }

        if ($query->hasParameter('statusId')) {
            $qb->andWhere($qb->expr()->eq('ticket.status', ':status'));
            $qb->setParameter('status', $query->statusId);
        }

        if ($query->hasParameter('userId')) {
            $qb->andWhere($qb->expr()->eq('ticket.owner', ':owner'));
            $qb->setParameter('owner', $query->userId);
        }

        if ($query->hasParameter('supportId')) {
            $qb->andWhere($qb->expr()->eq('ticket.support', ':support'));
            $qb->setParameter('support', $query->supportId);
        }

        $paginator = new Paginator($query->page, $query->perPage);
        $paginator->paginateWithORM($qb->getQuery());

        return $paginator->getResponse();
    }
}
