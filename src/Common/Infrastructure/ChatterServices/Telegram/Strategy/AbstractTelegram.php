<?php

namespace Common\Infrastructure\ChatterServices\Telegram\Strategy;

use Ticket\Domain\Entity\Ticket;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;

abstract class AbstractTelegram
{
    protected ?Ticket $ticket;

    abstract protected function getTelegramOptions(): TelegramOptions;

    abstract protected function getTelegramMessage(): ChatMessage;

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): void
    {
        $this->ticket = $ticket;
    }
}
