<?php

namespace Ticket\Application\Commands\Comment\Delete;

use Ticket\Domain\Entity\TicketComment;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class DeleteCommentCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(DeleteCommentCommand $command): TicketComment
    {
        $ticketComment = $command->ticketComment;

        $ticketComment->setIsDeleted(true);
        $ticketComment->setDeletedAt(new \DateTime());
        $ticketComment->setDeletedBy($command->user);

        $this->entityManager->persist($ticketComment);
        $this->entityManager->flush();

        return $ticketComment;
    }
}
