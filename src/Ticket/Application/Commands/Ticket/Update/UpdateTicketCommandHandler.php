<?php

namespace Ticket\Application\Commands\Ticket\Update;

use Ticket\Domain\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;
use Common\Application\Enum\TelegramChatterType;
use Ticket\Application\Events\Ticket\TicketEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UpdateTicketCommandHandler implements CommandHandler
{
    private ?Ticket $ticket;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    public function __invoke(UpdateTicketCommand $command): self
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

        $this->ticket = $ticket;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function triggerEvent(TelegramChatterType $chatterType): void
    {
        $this->dispatcher->dispatch(
            new TicketEvent(
                $this->getTicket()->getId()->toString(),
                $chatterType,
            ),
            TicketEvent::UPDATE_TICKET,
        );
    }
}
