<?php

namespace Ticket\Application\EventListeners\Ticket;

use Ticket\Domain\Entity\Ticket;
use Ticket\Application\Events\Ticket\TicketEvent;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Ticket\Application\Queries\Ticket\Find\FindTicketQuery;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Common\Infrastructure\ChatterService\Telegram\Ticket\New\ChatterTelegramNewTicket;

readonly class CreateTicketEventListener
{
    public function __construct(
        private MessengerQueryBus $queryBus,
        private ChatterTelegramNewTicket $chatterTelegramNewTicket,
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function __invoke(TicketEvent $event): void
    {
        /** @var Ticket $ticket */
        $ticket = $this->queryBus->handle(new FindTicketQuery($event->getId()));

        if (1 === (int) $this->parameterBag->get('chatter.telegram.enabled')) {
            // Telegram Chatter New Ticket
            $this->chatterTelegramNewTicket->handle($ticket);
        }
    }
}
