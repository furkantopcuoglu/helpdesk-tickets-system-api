<?php

namespace Ticket\Application\EventListeners\Ticket;

use Ticket\Domain\Entity\Ticket;
use Common\Domain\Message\SendEmailQueueMessage;
use Ticket\Application\Events\Ticket\TicketEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Ticket\Application\Queries\Ticket\Find\FindTicketQuery;
use Common\Domain\Message\SendTelegramNotificationQueueMessage;

readonly class CreateTicketEventListener
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

        // Telegram Chatter New Ticket
        $this->bus->dispatch(new SendTelegramNotificationQueueMessage([
            'ticket' => $ticket,
            'telegramChatterType' => $event->getChatterType(),
        ]));

        // Email Send New Ticket
        $this->bus->dispatch(new SendEmailQueueMessage([
            'user' => $ticket->getOwner(),
            'to' => $ticket->getOwner()->getEmail(),
            'subject' => 'New Help Desk Ticket TicketNo:'.$ticket->getTicketNo(),
            'content' => 'Content; '.$ticket->getContent(),
        ]));
    }
}
