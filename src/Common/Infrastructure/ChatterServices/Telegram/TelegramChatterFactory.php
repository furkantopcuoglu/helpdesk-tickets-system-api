<?php

namespace Common\Infrastructure\ChatterServices\Telegram;

use Common\Application\Enum\TelegramChatterType;
use Common\Infrastructure\ChatterServices\Telegram\Strategy\TelegramNewTicketStrategy;
use Common\Infrastructure\ChatterServices\Telegram\Strategy\TelegramChatterStrategyInterface;
use Common\Infrastructure\ChatterServices\Telegram\Strategy\TelegramAssigmentSupportTicketStrategy;

readonly class TelegramChatterFactory
{
    public function __construct(
        private TelegramNewTicketStrategy $newTicketStrategy,
        private TelegramAssigmentSupportTicketStrategy $assigmentSupportTicketStrategy,
    ) {
    }

    public function createTelegramChatter(TelegramChatterType $telegramChatterType): TelegramChatterStrategyInterface
    {
        return match ($telegramChatterType) {
            TelegramChatterType::ASSIGMENT_SUPPORT_TICKET => $this->assigmentSupportTicketStrategy,
            TelegramChatterType::NEW_TICKET => $this->newTicketStrategy,
        };
    }
}
