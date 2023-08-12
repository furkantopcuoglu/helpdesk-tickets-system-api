<?php

namespace Common\Infrastructure\ChatterServices\Telegram\Strategy;

use Ticket\Domain\Entity\Ticket;
use Symfony\Component\Notifier\Message\SentMessage;

interface TelegramChatterStrategyInterface
{
    public function sendMessage(Ticket $ticket): ?SentMessage;
}
