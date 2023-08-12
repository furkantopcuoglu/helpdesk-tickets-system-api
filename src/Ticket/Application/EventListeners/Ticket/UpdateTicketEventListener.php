<?php

namespace Ticket\Application\EventListeners\Ticket;

use Ticket\Domain\Entity\Ticket;
use Ticket\Application\Events\Ticket\TicketEvent;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Ticket\Application\Queries\Ticket\Find\FindTicketQuery;
use Common\Infrastructure\ChatterServices\Telegram\TelegramChatterFactory;

readonly class UpdateTicketEventListener
{
    public function __construct(
        private MessengerQueryBus $queryBus,
        private TelegramChatterFactory $telegramChatterFactory,
    ) {
    }

    public function __invoke(TicketEvent $event): void
    {
        /** @var Ticket $ticket */
        $ticket = $this->queryBus->handle(new FindTicketQuery($event->getId()));

        $this->telegramChatterFactory
            ->createTelegramChatter($event->getChatterType())
            ->sendMessage($ticket);
    }
}
