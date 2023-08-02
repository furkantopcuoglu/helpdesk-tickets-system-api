<?php

namespace Ticket\Domain\Entity;

use User\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Common\Application\Traits\UuidTrait;
use Common\Application\Traits\Deleteable;
use Common\Application\Traits\CreatedAtTrait;
use Ticket\Infrastructure\Repositories\Doctrine\TicketCommentRepository;

#[ORM\Entity(repositoryClass: TicketCommentRepository::class)]
#[ORM\Table(name: 'ticket_comments')]
class TicketComment
{
    use UuidTrait;
    use CreatedAtTrait;
    use Deleteable;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;

    #[ORM\ManyToOne(targetEntity: Ticket::class)]
    private ?Ticket $ticket;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user;

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): void
    {
        $this->ticket = $ticket;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
