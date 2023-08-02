<?php

namespace Common\Infrastructure\MessageBus;

use Common\Domain\Bus\AsyncMessage;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerBus
{
    use HandleTrait {
        handle as handleCommand;
    }

    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function dispatch(AsyncMessage $message): void
    {
        $this->bus->dispatch($message);
    }
}
