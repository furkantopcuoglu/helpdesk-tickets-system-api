<?php

namespace Common\Infrastructure\MessageBus;

use Common\Domain\Bus\Command\Command;
use Common\Domain\Bus\Command\CommandBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBus
{
    use HandleTrait {
        handle as handleCommand;
    }

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(Command $command): void
    {
        $this->messageBus->dispatch($command);
    }

    public function handle(Command $command)
    {
        return $this->handleCommand($command);
    }
}
