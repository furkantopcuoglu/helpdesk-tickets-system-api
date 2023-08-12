<?php

namespace Ticket\Application\Commands\Ticket\Create;

use Common\Domain\Entity\Media;
use Ticket\Domain\Entity\Ticket;
use App\Application\Enum\StatusType;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;
use Common\Application\Traits\RandomUniqTrait;
use Common\Application\Enum\TelegramChatterType;
use Ticket\Application\Events\Ticket\TicketEvent;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Application\Queries\Status\FindOneBy\FindOneByStatusQuery;
use Ticket\Application\Commands\File\Create\CreateTicketFileCommand;

class CreateTicketCommandHandler implements CommandHandler
{
    use RandomUniqTrait;

    private ?Ticket $ticket;

    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    public function __invoke(CreateTicketCommand $command): self
    {
        try {
            $this->entityManager->beginTransaction();

            $ticket = new Ticket();

            $defaultStatus = $this->queryBus->handle(new FindOneByStatusQuery([
                'name' => StatusType::NEW->value,
            ]));

            $ticket->setSubject($command->subject);
            $ticket->setTicketNo($this->generateRandomUniqWithPrefix('HD', 10));
            $ticket->setContent($command->content);
            $ticket->setPriority($command->priority);
            $ticket->setStatus($defaultStatus);
            $ticket->setCategory($command->category);
            $ticket->setOwner($command->owner);
            $ticket->setCreatedAt(new \DateTime());

            $this->entityManager->persist($ticket);
            $this->entityManager->flush();

            // Ticket Files Created
            collect($command->files)->map(function (Media $media) use ($ticket) {
                $this->commandBus->handle(new CreateTicketFileCommand([
                    'ticket' => $ticket,
                    'media' => $media,
                ]));
            });
        } catch (\Throwable $exception) {
            $this->entityManager->rollback();
            $ticket = null;
        }

        $this->entityManager->commit();

        $this->ticket = $ticket;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function triggerEvent(): void
    {
        $this->dispatcher->dispatch(
            new TicketEvent(
                $this->getTicket()->getId()->toString(),
                TelegramChatterType::NEW_TICKET,
            ),
            TicketEvent::CREATE_TICKET,
        );
    }
}
