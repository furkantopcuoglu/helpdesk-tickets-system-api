<?php

namespace Support\Presentation\App\Ticket\Assigment;

use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use App\Domain\Exceptions\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Enum\TelegramChatterType;
use Common\Application\Utils\RouteRequirementUtil;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use Ticket\Application\Commands\Ticket\Update\UpdateTicketCommand;
use Ticket\Application\Queries\Ticket\FindOneBy\FindOneByTicketQuery;
use Ticket\Application\Commands\Ticket\Update\UpdateTicketCommandHandler;

#[Route(
    path: '/api/support/assigment-ticket/{ticketId}',
    requirements: [
        'ticketId' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_POST,
)]
class TicketAssigmentController extends AbstractController
{
    public function __construct(
        private readonly MessengerQueryBus $queryBus,
        private readonly MessengerCommandBus $commandBus,
    ) {
    }

    public function __invoke(string $ticketId): Payload
    {
        $ticket = $this->queryBus->handle(new FindOneByTicketQuery([
            'id' => $ticketId,
            'isAssigment' => null,
        ]));

        if (!$ticket) {
            throw new NotFoundException('TICKET_NOT_FOUND');
        }

        /** @var UpdateTicketCommandHandler $updateTicketCommandHandler */
        $updateTicketCommandHandler = $this->commandBus->handle(new UpdateTicketCommand([
            'ticket' => $ticket,
            'updatedBy' => $this->getUser(),
            'support' => $this->getUser(),
        ]));

        // Assigment Ticket Support Trigger Event
        $updateTicketCommandHandler->triggerEvent(TelegramChatterType::ASSIGMENT_SUPPORT_TICKET);

        return $this->createPayload()->setStatus(PayloadStatus::CREATED);
    }
}
