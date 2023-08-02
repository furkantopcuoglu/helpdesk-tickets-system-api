<?php

namespace Ticket\Application\Commands\File\Create;

use Ticket\Domain\Entity\TicketFile;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class CreateTicketFileCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateTicketFileCommand $command): TicketFile
    {
        $ticketFile = new TicketFile();

        $ticketFile->setTicket($command->ticket);
        $ticketFile->setTicketComment($command->ticketComment);
        $ticketFile->setMedia($command->media);
        $ticketFile->setCreatedAt(new \DateTime());

        $this->entityManager->persist($ticketFile);
        $this->entityManager->flush();

        return $ticketFile;
    }
}
