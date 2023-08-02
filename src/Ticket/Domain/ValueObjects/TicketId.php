<?php

namespace Ticket\Domain\ValueObjects;

class TicketId
{
    public function __construct(
        private readonly string $ticketId,
    ) {
    }

    public function getTicketId(): string
    {
        return $this->ticketId;
    }
}
