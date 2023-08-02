<?php

namespace Common\Infrastructure\MessageBus;

use Common\Domain\Bus\Query\Query;
use Common\Domain\Bus\Query\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function handle(Query $message): mixed
    {
        return $this->handleQuery($message);
    }
}
