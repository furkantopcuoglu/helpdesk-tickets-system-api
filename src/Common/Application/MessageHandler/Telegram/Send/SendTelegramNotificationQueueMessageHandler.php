<?php

namespace Common\Application\MessageHandler\Telegram\Send;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Common\Domain\Message\SendTelegramNotificationQueueMessage;
use Common\Infrastructure\ChatterServices\Telegram\TelegramChatterFactory;

#[AsMessageHandler]
readonly class SendTelegramNotificationQueueMessageHandler
{
    public function __construct(
        private TelegramChatterFactory $telegramChatterFactory,
    ) {
    }

    public function __invoke(SendTelegramNotificationQueueMessage $message): void
    {
        $this->telegramChatterFactory
            ->createTelegramChatter($message->telegramChatterType)
            ->sendMessage($message->ticket);
    }
}
