<?php

namespace Ticket\Application\Commands\File\Delete;

use Ticket\Domain\Entity\TicketFile;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class DeleteTicketFileCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(DeleteTicketFileCommand $command): TicketFile
    {
        $ticketFile = $command->ticketFile;

        $ticketFile->setDeletedBy($command->user);
        $ticketFile->setDeletedAt(new \DateTime());
        $ticketFile->setIsDeleted(true);

        $this->entityManager->persist($ticketFile);
        $this->entityManager->flush();

        return $ticketFile;
    }
}
