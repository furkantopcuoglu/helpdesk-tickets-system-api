<?php

namespace Ticket\Application\Commands\Comment\Create;

use Ticket\Domain\Entity\TicketComment;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class CreateCommentCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateCommentCommand $command): TicketComment
    {
        $ticketComment = new TicketComment();

        $ticketComment->setContent($command->content);
        $ticketComment->setUser($command->user);
        $ticketComment->setTicket($command->ticket);
        $ticketComment->setCreatedAt(new \DateTime());

        $this->entityManager->persist($ticketComment);
        $this->entityManager->flush();

        return $ticketComment;
    }
}
