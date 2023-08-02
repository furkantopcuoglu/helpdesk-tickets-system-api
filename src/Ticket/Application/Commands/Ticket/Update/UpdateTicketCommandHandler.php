<?php

namespace Ticket\Application\Commands\Ticket\Update;

use Ticket\Domain\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class UpdateTicketCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdateTicketCommand $command): Ticket
    {
        $ticket = $command->ticket;

        if ($command->hasParameter('subject')) {
            $ticket->setSubject($command->subject);
        }

        if ($command->hasParameter('content')) {
            $ticket->setContent($command->content);
        }

        if ($command->hasParameter('support')) {
            $ticket->setSupport($command->support);
        }

        if ($command->hasParameter('status')) {
            $ticket->setStatus($command->status);
        }

        if ($command->hasParameter('priority')) {
            $ticket->setPriority($command->priority);
        }

        if ($command->hasParameter('category')) {
            $ticket->setCategory($command->category);
        }

        if ($command->hasParameter('isCompleted')) {
            $ticket->setIsCompleted($command->isCompleted);
            $ticket->setCompletedAt(new \DateTime());
        }

        if ($command->hasParameter('isDeleted')) {
            $ticket->setIsDeleted($command->isDeleted);
            $ticket->setDeletedAt(new \DateTime());
            $ticket->setDeletedBy($command->updatedBy);
        }

        if ($command->hasParameter('isArchive')) {
            $ticket->setIsArchive($command->isArchive);
            $ticket->setArchiveAt(new \DateTime());
            $ticket->setArchiveBy($command->updatedBy);
        }

        $ticket->setUpdatedAt(new \DateTime());
        $ticket->setUpdatedBy($command->updatedBy);

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $ticket;
    }
}
