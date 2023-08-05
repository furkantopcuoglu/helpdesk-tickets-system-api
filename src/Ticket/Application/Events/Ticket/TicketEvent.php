<?php

namespace Ticket\Application\Events\Ticket;

use Symfony\Contracts\EventDispatcher\Event;

class TicketEvent extends Event
{
    public const CREATE_TICKET = 'create.ticket';

    public function __construct(
        private string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
}
