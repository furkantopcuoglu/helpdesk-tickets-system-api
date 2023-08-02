<?php

namespace Ticket\Domain\Entity;

use Common\Domain\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Common\Application\Traits\UuidTrait;
use Common\Application\Traits\Deleteable;
use Common\Application\Traits\CreatedAtTrait;
use Ticket\Infrastructure\Repositories\Doctrine\TicketFileRepository;

#[ORM\Entity(repositoryClass: TicketFileRepository::class)]
#[ORM\Table(name: 'ticket_files')]
class TicketFile
{
    use UuidTrait;
    use CreatedAtTrait;
    use Deleteable;

    #[ORM\ManyToOne(targetEntity: Ticket::class)]
    private ?Ticket $ticket;

    #[ORM\ManyToOne(targetEntity: TicketComment::class)]
    private ?TicketComment $ticketComment;

    #[ORM\ManyToOne(targetEntity: Media::class)]
    private ?Media $media;

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): void
    {
        $this->ticket = $ticket;
    }

    public function getTicketComment(): ?TicketComment
    {
        return $this->ticketComment;
    }

    public function setTicketComment(?TicketComment $ticketComment): void
    {
        $this->ticketComment = $ticketComment;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): void
    {
        $this->media = $media;
    }
}
