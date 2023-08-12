<?php

namespace Ticket\Application\Events\Ticket;

use Symfony\Contracts\EventDispatcher\Event;
use Common\Application\Enum\TelegramChatterType;

class TicketEvent extends Event
{
    public const CREATE_TICKET = 'create.ticket';
    public const UPDATE_TICKET = 'update.ticket';

    public function __construct(
        private string $id,
        private TelegramChatterType $chatterType,
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

    public function getChatterType(): TelegramChatterType
    {
        return $this->chatterType;
    }

    public function setChatterType(TelegramChatterType $chatterType): void
    {
        $this->chatterType = $chatterType;
    }
}
