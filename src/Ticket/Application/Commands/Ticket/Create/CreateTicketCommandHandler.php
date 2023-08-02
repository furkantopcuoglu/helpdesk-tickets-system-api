<?php

namespace Ticket\Application\Commands\Ticket\Create;

use Ticket\Domain\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class CreateTicketCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateTicketCommand $command): Ticket
    {
        $ticket = new Ticket();

        $ticket->setSubject($command->subject);
        $ticket->setContent($command->content);
        $ticket->setPriority($command->priority);
        $ticket->setStatus($command->status);
        $ticket->setCategory($command->category);
        $ticket->setOwner($command->owner);
        $ticket->setCreatedAt(new \DateTime());

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $ticket;
    }
}
