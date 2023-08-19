<?php

namespace Ticket\Application\EventListeners\Ticket;

use Ticket\Domain\Entity\Ticket;
use Ticket\Application\Events\Ticket\TicketEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Ticket\Application\Queries\Ticket\Find\FindTicketQuery;
use Common\Domain\Message\SendTelegramNotificationQueueMessage;

readonly class UpdateTicketEventListener
{
    public function __construct(
        private MessengerQueryBus $queryBus,
        private MessageBusInterface $bus,
    ) {
    }

    public function __invoke(TicketEvent $event): void
    {
        /** @var Ticket $ticket */
        $ticket = $this->queryBus->handle(new FindTicketQuery($event->getId()));

        // Update Ticket Telegram Notification
        $this->bus->dispatch(new SendTelegramNotificationQueueMessage([
            'ticket' => $ticket,
            'telegramChatterType' => $event->getChatterType(),
        ]));
    }
}
